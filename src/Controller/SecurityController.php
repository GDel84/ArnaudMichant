<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserFormType;
use App\Repository\ScheduleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Bundle\SecurityBundle\Security as SecurityBundleSecurity;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasher;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
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
    public function someAction(SecurityBundleSecurity $security): Response
    {

        // you can also disable the csrf logout
        $response = $security->logout(false);

        return $response;
        
    }

    #[Route('/moncompte', name: 'moncompte')]
    public function MonCompte(ManagerRegistry $doctrine, Request $request, Security $security, ScheduleRepository $scheduleRepo)
    {
        $user = $security->getUser();
        $form = $this->createForm(UserFormType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $em = $doctrine->getManager();
            $em->persist($user);
            $em->flush();
        }

        return $this->render('moncompte.html.twig', [
            'schedules' => $scheduleRepo->findAll(),
            'user' => $form->createView(),
        ]);
    }
    #[Route('/user/edit-password/{id}', name: 'edit-password')]
    public function editPassword(Request $request, User $user, ScheduleRepository $scheduleRepo, UserPasswordHasherInterface $hasher, EntityManagerInterface $manager)
    {
        $form = $this->createForm(UserPasswordFormType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if ($hasher->isPasswordValid($user, $form->getData()['password'])) {
                $user->setPassword(
                    $form->getData()['newPassword']
                );
                $this->addFlash(
                    'success',
                    'Le mot de passe a été modifié.'
                );

                $manager->persist($user);
                $manager->flush();

                return $this->redirectToRoute('recipe.index');
            } else {
                $this->addFlash(
                    'warning',
                    'Le mot de passe renseigné est incorrect.'
                );
            }
        }
        return $this->render('security/edit-password.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
