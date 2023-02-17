<?php

namespace App\Controller\Admin;

use App\Entity\Carte;
use App\Repository\CarteRepository;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    #[Route('/admin/carte', name: 'admin-carte')]
    public function carte(ProductRepository $productRepo, CategoryRepository $categoryRepo): Response
    {
        return $this->render('admin/carte/admin-carte.html.twig', [
            'products' => $productRepo->findAll(),
            'categorys' => $categoryRepo->findBy(array(),array('CategoryOrder'=>'asc')),
        ]);
    }
}
