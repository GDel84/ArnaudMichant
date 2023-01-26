<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Repository\PhotoRepository;
use App\Repository\ScheduleRepository;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController

{
    #[Route('/', name: 'accueil')]
    public function accueil(ScheduleRepository $scheduleRepo, PhotoRepository $pictureRepo): Response
    {
        return $this->render('accueil.html.twig', [
            'accueil_name' => 'PublicController',
            'schedules' => $scheduleRepo->findAll(),
            'pictures' => $pictureRepo->findall(),
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
    #[Route('/getdate', name: 'getdate', methods: ['POST','GET'])]
    public function getdate(ScheduleRepository $scheduleRepo, Request $request): Response
    {
        $dateSelect = $request->request->get('date');
        $dateReal = DateTime::createFromFormat('Y-m-d', $dateSelect);
        $weekDay = $dateReal->format('w');

        $horaire = $scheduleRepo->findOneBy(['week'=>$weekDay]);

        $resp = [
            'noon'=>['start'=>$horaire->getNoonStartTime(),'end'=>$horaire->getNoonEndTime()],
            'night'=>['start'=>$horaire->getNightStartTime(), 'end'=>$horaire->getNightEndTime()] 
        ];

        return new JsonResponse($resp);
    }
    #[Route('/gettime', name: 'gettime', methods: ['POST','GET'])]
    public function gettime(ScheduleRepository $scheduleRepo, Request $request): Response
    {
        dump($request->request->get('time'));
        $resp = ['Guigui'];
        return new JsonResponse($resp);
    }
}