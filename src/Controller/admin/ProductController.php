<?php

namespace App\Controller\Admin;

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
    #[Route('/admin/product/create/', name: 'admin-product-create')]
        public function CreateProduct(ManagerRegistry $doctrine, Request $request)
        {
            $product = new Product;
    
            $form = $this->createForm(ProductFormType::class, $product);
    
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
    
                    $em = $doctrine->getManager();
                    $em->persist($product);
                    $em->flush();

            return $this->redirectToRoute('admin-carte');

            }
            return $this->render('/admin/product/admin-product-create.html.twig', [
                'form' => $form->createView()
            ]);
        }

    #[Route('/admin/product/modifier/{id}', name: 'admin-product-edit')]
    public function ModifProduct(ManagerRegistry $doctrine, $id, Request $request)
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
            'form' => $form->createView()
        ]);
    }
    #[Route('/admin/produit/delete/{id}', name: 'admin-produit-delete')]
        public function produitDelete(Product $product, ManagerRegistry $doctrine): RedirectResponse
        {
            $em = $doctrine->getManager();
            $em->remove($product);
            $em->flush();

        return $this->redirectToRoute("admin-carte");
        }
}
