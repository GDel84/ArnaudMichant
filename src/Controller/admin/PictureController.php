<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PictureController extends AbstractController
{
    #[Route('/picture', name: 'app_picture')]
    public function index(): Response
    {
        return $this->render('picture/admin-picture.html.twig', [
            'controller_name' => 'PictureController',
        ]);
    }
}
