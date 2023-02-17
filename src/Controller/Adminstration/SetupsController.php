<?php

namespace App\Controller\Admin;

use App\Entity\Setups;
use App\Form\SetupsFormType;
use App\Repository\ReservationsRepository;
use App\Repository\SetupsRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SetupsController extends AbstractController
{
    #[Route('admin/setups', name: 'admin-setups')]
    public function setups(ReservationsRepository $reservationRepo, SetupsRepository $setupsRepo): Response
    {
        return $this->render('/admin/setups/admin-setups.html.twig', [
            'reservations' => $reservationRepo->findAll(),
            'setups' => $setupsRepo->findAll(),            
        ]);
    }

    #[Route('admin/setups/create', name: 'admin-setups-create')]
    public function setupsCreate(ManagerRegistry $doctrine, Request $request)
    {
        $setups = new Setups;
        $form = $this->createForm(SetupsFormType::class, $setups);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $em->persist($setups);
            $em->flush(); 

            return $this->redirectToRoute('admin');

        }
        return $this->render('/admin/setups/admin-setups-create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('admin/setups/edit/{id}', name: 'admin-setups-edit')]
    public function setupsEdit(ManagerRegistry $doctrine, $id, Request $request, SetupsRepository $setupsRepo)
    {
        $setupsRepo = $doctrine->getRepository(Setups::class);
        $setups = $setupsRepo->findOneBy(['id'=>$id]);
        $form = $this->createForm(SetupsFormType::class, $setups);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($setups);
            $em->flush();

            return $this->redirectToRoute('admin');
        }

        return $this->render('admin/setups/admin-setups-edit.html.twig', [
            'setupsEdit' => $form->createView(),
        ]);
    }
}
