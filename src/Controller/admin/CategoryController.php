<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'category')]
    public function index(CategoryRepository $categoryRepo): Response
    {
        return $this->render('category/admin-category.html.twig', [
            'category' => $categoryRepo->finAll(),
        ]);
    }

    #[Route('admin/category/edit/{id}', name: 'category-edit')]
    public function categoryAdd(ManagerRegistry $doctrine, $id, Request $request)
    {
        $category = new Category;
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush(); 
        }
        return $this->render('/admin/category/admin-category-create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('admin/category/edit/{id}', name: 'category-edit')]
    public function categoryEdit(ManagerRegistry $doctrine, $id, Request $request)
    {
        $categoryRepo = $doctrine->getRepository(Category::class);
        $category = $categoryRepo->findOneBy(['id'=>$id]);
        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('category');
        }

        return $this->render('admin/category/admin-category-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/category/delete/{id}', name: 'category-delete')]
        public function categoryDelete(Category $category, ManagerRegistry $doctrine): RedirectResponse
        {
            $em = $doctrine->getManager();
            $em->remove($category);
            $em->flush();

        return $this->redirectToRoute("category");
        }
}
