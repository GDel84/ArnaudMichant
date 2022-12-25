<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ScheduleController extends AbstractController
{
    #[Route('/schedule', name: 'app_schedule')]
    public function index(): Response
    {
        return $this->render('schedule/admin-schedule.html.twig', [
            'controller_name' => 'ScheduleController',
        ]);
    }
}
