<?php

namespace App\Controller;

use App\Repository\ScheduleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController

{
    #[Route('/', name: 'accueil')]
    public function accueil(ScheduleRepository $scheduleRepo): Response
    {
        return $this->render('accueil.html.twig', [
            'accueil_name' => 'PublicController',
            'schedules' => $scheduleRepo->findAll(),
        ]);
    }
    #[Route('/carte', name: 'carte')]
    public function contacter(ScheduleRepository $scheduleRepo): Response
    {
        return $this->render('carte.html.twig', [
            'carte_name' => 'PublicController',
            'schedules' => $scheduleRepo->findAll(),
        ]);
    }
    #[Route('/reservation', name: 'reservation')]
    public function reservation(ScheduleRepository $scheduleRepo): Response
    {
        return $this->render('reservation.html.twig', [
            'reservation_name' => 'PublicController',
            'schedules' => $scheduleRepo->findAll(),
        ]);
    }
}