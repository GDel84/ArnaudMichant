<?php

namespace App\Controller\Admin;

use App\Entity\Carte;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    #[Route('/admin/carte', name: 'carte')]
    public function index(): Response
    {
        return $this->render('carte/admin-carte.html.twig', [
            'controller_name' => 'CarteController',
        ]);
    }
    #[Route('admin/category/create/', name: 'category-create')]
    public function categoryAdd(ManagerRegistry $doctrine, Request $request)
    {
        $carte = new Carte;
        $form = $this->createForm(CarteFormType::class, $carte);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $em->persist($carte);
            $em->flush(); 
        }
        return $this->render('/admin/carte/admin-carte-create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('admin/carte/edit/{id}', name: 'carte-edit')]
    public function carteEdit(ManagerRegistry $doctrine, $id, Request $request)
    {
        $carteRepo = $doctrine->getRepository(Carte::class);
        $carte = $carteRepo->findOneBy(['id'=>$id]);
        $form = $this->createForm(CarteFormType::class, $carte);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($carte);
            $em->flush();

            return $this->redirectToRoute('carte');
        }

        return $this->render('admin/carte/admin-carte-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/carte/delete/{id}', name: 'carte-delete')]
        public function carteDelete(Carte $carte, ManagerRegistry $doctrine): RedirectResponse
        {
            $em = $doctrine->getManager();
            $em->remove($carte);
            $em->flush();

        return $this->redirectToRoute("carte");
        }
}
