<?php

namespace App\Controller\Admin;

use App\Entity\Horaires;
use App\Form\HorairesFormType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class ScheduleController extends AbstractController
{
    #[Route('/admin/schedule', name: 'admin-schedule')]
    public function index(): Response
    {
        return $this->render('admin/schedule/admin-schedule.html.twig', [
            'controller_name' => 'ScheduleController',
        ]);
    }

    #[Route('/admin/schedule/create/', name: 'admin_schedule_create')]
        public function CreateSchedule(ManagerRegistry $doctrine, Request $request, SluggerInterface $slugger)
        {
            $horaires = new Horaires;
    
            $form = $this->createForm(HorairesFormType::class, $horaires);
    
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
        $horaireRepo = $doctrine->getRepository(Horaires::class);
        $horaire = $horaireRepo->findOneBy(['id'=>$id]);
        $form = $this->createForm(HorairesAdminType::class, $horaire);

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
