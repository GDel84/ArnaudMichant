<?php

namespace App\Controller;

use App\Entity\Schedule;
use App\Repository\CategoryRepository;
use App\Repository\PhotoRepository;
use App\Repository\ReservationsRepository;
use App\Repository\ScheduleRepository;
use App\Repository\SetupsRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefaultController extends AbstractController

{
    #[Route('/', name: 'accueil')]
    public function accueil(ScheduleRepository $scheduleRepo, PhotoRepository $picRepo): Response
    {
        return $this->render('accueil.html.twig', [
            'schedules' => $scheduleRepo->findAll(),
            'pictures' => $picRepo->findBy(array(),array('pictureOrder'=>'asc')),
        ]);
    }
    #[Route('/carte', name: 'carte')]
    public function contacter(ScheduleRepository $scheduleRepo, CategoryRepository $categoryRepo): Response
    {
        return $this->render('carte.html.twig', [
            'schedules' => $scheduleRepo->findAll(),
            'categorys' => $categoryRepo->findBy(array(),array('CategoryOrder'=>'asc')),
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
    #[Route('/mentionslegales', name: 'mentions-legales')]
    public function mentionsLegale(ScheduleRepository $scheduleRepo, PhotoRepository $picRepo): Response
    {
        return $this->render('mentionLegale.html.twig', [
            'schedules' => $scheduleRepo->findAll(),
        ]);
    }
    //Route d'appel du DOM pour récupérer un tableau d'horaire
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
    //Route d'appel du DOM pour récupérer les places disponibles
    #[Route('/getdispo', name: 'getdispo', methods: ['POST','GET'])]
    public function getdispo(SetupsRepository $SetupRepo, ReservationsRepository $ResaRepo, ScheduleRepository $scheduleRepo, Request $request): Response
    {
        $formdate = $request->request->get('date');
        $formtime = $request->request->get('time');
        $time = substr($formtime, 0, 2);

        $noon = false;
        if( $time < 15 ){
           $noon = true;
        }

        $datereservation = DateTime::createFromFormat('Y-m-d H:i', $formdate.' '.$formtime);
        
        $weekDay = $datereservation->format('w');
        $weekSchedule = $scheduleRepo->findOneBy(['week'=>$weekDay]);
        
        if($noon == true){
            $start = $weekSchedule->getNoonStartTime()->modify($formdate);
            $end = $weekSchedule->getNoonEndTime()->modify($formdate);
        } else {
            $start = $weekSchedule->getNightStartTime()->modify($formdate);
            $end = $weekSchedule->getNightEndTime()->modify($formdate);
        }

        $nbresa = $ResaRepo->nbplace($start, $end);
        //recupere le nombre de place disponible dans le setups
        $place = $SetupRepo->findOneBy([
            'clefs'=>"place disponible"
        ]);
        $placeDispo = $place->getvalue();
        $nbplaceslibres = ($placeDispo - $nbresa[0]['totalcouverts']);
        
        $tableresult = ['dispo'=>$nbplaceslibres];  
              
        return new JsonResponse($tableresult);
    }

}