<?php

namespace App\Controller;

use App\Form\UserFormType;
use App\Repository\ScheduleRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;


class SecurityController extends AbstractController
{
    #[Route(path: '/login', name: 'login')]
    public function login(AuthenticationUtils $authenticationUtils, ScheduleRepository $scheduleRepo, Security $security): Response
    {
        $user = $security->getUser();
        // if ($this->getUser()) {
        //     return $this->redirectToRoute('target_path');
        // }

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername, 'error' => $error,
            'schedules' => $scheduleRepo->findAll(),
            'user' => $user,
            ]);
        
    }

    #[Route(path: '/logout', name: 'logout')]
    public function logout(): void
    {
        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    #[Route('/moncompte', name: 'moncompte')]
    public function MonCompte(ManagerRegistry $doctrine, Request $request, Security $security, ScheduleRepository $scheduleRepo)
        {
            $user = $security->getUser();
            dump($user);
            $form = $this->createForm(UserFormType::class, $user);

    
            $form->handleRequest($request);
    
            if($form->isSubmitted() && $form->isValid()){

                $user = $form->getData();
                $em = $doctrine->getManager();
                $em->persist($user);
                $em->flush();
            }
        return $this->render('moncompte.html.twig', [
            'moncompte_name' => 'SecurityController',
            'schedules' => $scheduleRepo->findAll(),
            'form' => $form->createView(),
        ]);
    }
}
