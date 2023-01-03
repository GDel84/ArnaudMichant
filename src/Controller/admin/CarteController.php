<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarteController extends AbstractController
{
    #[Route('/admin/carte', name: 'app_carte')]
    public function index(): Response
    {
        return $this->render('carte/admin-carte.html.twig', [
            'controller_name' => 'CarteController',
        ]);
    }
}
