<?php

namespace App\Controller\Admin;

use App\Repository\PhotoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'admin')]
    public function index(PhotoRepository $picRepo): Response
    {
        return $this->render('admin/index.html.twig', [
            'pictures' => $picRepo->findAll(),
        ]);
    }
}
