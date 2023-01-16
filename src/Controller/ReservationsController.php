<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Form\ReservationsFormType;
use App\Repository\ScheduleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReservationsController extends AbstractController
{
    #[Route('/reservation', name: 'reservation')]
    public function reservations(ManagerRegistry $doctrine, Request $request, ScheduleRepository $scheduleRepo)
    {
        $reservation = new Reservations();
        $form = $this->createForm(ReservationsFormType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $doctrine->getManager();
            $em->persist($reservation);
            $em->flush(); 

            return $this->redirectToRoute('accueil');

        }
        return $this->render('reservation.html.twig', [
            'reservationForm' => $form->createView(),
            'schedules' => $scheduleRepo->findAll(),
        ]);
    }
}
