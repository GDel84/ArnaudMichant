<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Form\CategoryFormType;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    #[Route('/admin/category', name: 'admin-category')]
    public function index(CategoryRepository $categoryRepo): Response
    {
        return $this->render('category/admin-category.html.twig', [
            'categorys' => $categoryRepo->findBy(array(),array('CategoryOrder'=>'asc')),
        ]);
    }

    #[Route('admin/category/create', name: 'admin-category-create')]
    public function categoryCreate(ManagerRegistry $doctrine, Request $request)
    {
        $category = new Category;
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush(); 

            return $this->redirectToRoute('admin-carte');

        }
        return $this->render('/admin/category/admin-category-create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    #[Route('admin/category/edit/{id}', name: 'admin-category-edit')]
    public function categoryEdit(ManagerRegistry $doctrine, $id, Request $request, ProductRepository $productRepo)
    {
        $categoryRepo = $doctrine->getRepository(Category::class);
        $category = $categoryRepo->findOneBy(['id'=>$id]);
        $form = $this->createForm(CategoryFormType::class, $category);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($category);
            $em->flush();

            return $this->redirectToRoute('admin-carte');
        }

        return $this->render('admin/category/admin-category-edit.html.twig', [
            'form' => $form->createView(),
            'products' => $productRepo->findBy(['Category' => $category]),
            'categorys' => $categoryRepo->find(id:$id),
        ]);
    }

    #[Route('/admin/category/delete/{id}', name: 'admin-category-delete')]
        public function categoryDelete(Category $category, ManagerRegistry $doctrine): RedirectResponse
        {
            $em = $doctrine->getManager();
            $em->remove($category);
            $em->flush();

        return $this->redirectToRoute("admin-carte");
        }

        #[Route('category/move/{id}/{move}', name: 'category-move')]
        public function categoryMove(ManagerRegistry $doctrine, $move, $id){
    
            $em = $doctrine->getManager();
            $categoryRepo = $doctrine->getRepository(Category::class);
            $category = $categoryRepo->findOneBy(array('id'=>$id)); 
    
            if($category->getCategoryOrder()==null){
                $category->setCategoryOrder(0);
            }
            if($move=='haut'){
                $position=$category->getCategoryOrder();
                if($position!=0){
                    $position = $position-1;
                }  
            }
            if($move=='bas'){
                $position=$category->getCategoryOrder();
                if($position!=0){
                    $position = $position+1;
                }
            }
            $categoryInvers=$categoryRepo->findOneBy(array('CategoryOrder'=>$position));
            if($categoryInvers){
                $categoryInvers->setCategoryOrder($category->getCategoryOrder());
                $em->persist($categoryInvers);
            }
            $category->setCategoryOrder($position);
            
            $em->persist($category);
            $em->flush();
            
            return $this->redirectToRoute('admin-carte');
        }
}
