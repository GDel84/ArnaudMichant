<?php

namespace App\Controller\Admin;

use App\Entity\Schedule;
use App\Form\ScheduleFormType;
use App\Repository\ScheduleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ScheduleController extends AbstractController
{
    #[Route('/admin/schedule', name: 'admin-schedule')]
    public function index(ScheduleRepository $horaireRepo): Response
    {
        return $this->render('admin/schedule/admin-schedule.html.twig', [
            'schedules' => $horaireRepo->findAll(),
        ]);
    }

    #[Route('/admin/schedule/create/', name: 'schedule-create')]
        public function CreateSchedule(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
        {
            $horaires = new Schedule;
    
            $form = $this->createForm(ScheduleFormType::class, $horaires);
    
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){
    
                    $em = $doctrine->getManager();
                    $em->persist($horaires);
                    $em->flush();
            }
            return $this->render('/admin/schedule/admin-schedule-create.html.twig', [
                'form' => $form->createView()
            ]);
        }

    #[Route('/modifier/{id}', name: 'admin-schedule-edit')]
    public function ModifHoraire(ManagerRegistry $doctrine, $id, Request $request)
    {
        $horaireRepo = $doctrine->getRepository(Schedule::class);
        $horaire = $horaireRepo->findOneBy(['id'=>$id]);
        $form = $this->createForm(ScheduleFormType::class, $horaire);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $em = $doctrine->getManager();
            $em->persist($horaire);
            $em->flush();

            return $this->redirectToRoute('admin-schedule');
        }

        return $this->render('admin/schedule/admin-schedule-edit.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
