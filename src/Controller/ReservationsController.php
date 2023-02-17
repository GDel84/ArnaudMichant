<?php

namespace App\Controller;

use App\Entity\Reservations;
use App\Entity\User;
use App\Form\ReservationsFormType;
use App\Repository\ScheduleRepository;
use DateTime;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;

class ReservationsController extends AbstractController
{
    #[Route('/reservation', name: 'reservation', methods:['POST', 'GET'])] 
    public function reservations(ManagerRegistry $doctrine, Request $request, ScheduleRepository $scheduleRepo, Security $security)
    {
        $user = $security->getUser();
        
        if ($request->get('user_scheduled')) {
            $reservation = new Reservations;
            $dateReservation = DateTime::createFromFormat('Y-m-d H:i', $request->get('user_scheduled').' '.$request->get('time'));

            $reservation->setName($request->get('user_name'));
            $reservation->setLastName($request->get('user_LastName'));
            $reservation->setEmail($request->get('user_email'));
            $reservation->setNbcouverts($request->get('nbcouverts'));
            $reservation->setMentionsAllergene($request->get('mentions_allergene'));
            $reservation->setScheduledTime($dateReservation);
            if ($user){
                $reservation->setUserResa($user);
            }

            $em = $doctrine->getManager();
            $em->persist($reservation);
            $em->flush(); 
            
            $this->addFlash('notice', 'Merci votre réservation est bien prise en compte !');
            return $this->redirectToRoute('accueil');

        }
        return $this->render('reservation.html.twig', [
            'schedules' => $scheduleRepo->findAll(),
            'user'=> $user,
        ]);
    }
}
