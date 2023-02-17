<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\ProductFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/admin/product', name: 'admin-product')]
    public function index(): Response
    {
        return $this->render('/adminproduct/index.html.twig', [
            'controller_name' => 'produitController',
        ]);
    }
    #[Route('/admin/product/create/{category}', name: 'admin-product-create')]
        public function CreateProduct(ManagerRegistry $doctrine, Request $request, Category $category=null)
        {
            $product = new Product;
            if($category != null){
                $product->setCategory($category);
            }
            $form = $this->createForm(ProductFormType::class, $product);
    
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
    
                    $em = $doctrine->getManager();
                    $em->persist($product);
                    $em->flush();

            return $this->redirectToRoute('admin-carte', ['_fragment' => $category->getId()]);

            }
            return $this->render('/admin/product/admin-product-create.html.twig', [
                'productForm' => $form->createView()
            ]);
        }

    #[Route('/admin/product/edit/{id}', name: 'admin-product-edit')]
    public function productEdit(ManagerRegistry $doctrine, $id, Request $request)
    {
        $productRepo = $doctrine->getRepository(Product::class);
        $horaire = $productRepo->findOneBy(['id'=>$id]);
        $form = $this->createForm(ProductFormType::class, $horaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($horaire);
            $em->flush();

            return $this->redirectToRoute('admin-carte');
        }

        return $this->render('admin/product/admin-product-edit.html.twig', [
            'productForm' => $form->createView()
        ]);
    }
    #[Route('/admin/product/delete/{id}', name: 'admin-product-delete')]
        public function productDelete(Product $product, ManagerRegistry $doctrine): RedirectResponse
        {
            $em = $doctrine->getManager();
            $em->remove($product);
            $em->flush();

        return $this->redirectToRoute("admin-carte");
        }
}
