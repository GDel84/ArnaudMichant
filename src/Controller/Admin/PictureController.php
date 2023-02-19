<?php

namespace App\Controller\Admin;

use App\Entity\Photo;
use App\Form\PictureFormType;
use App\Repository\PhotoRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

class PictureController extends AbstractController
{
    #[Route('/admin/picture', name: 'admin-picture')]
    public function picture(PhotoRepository $picRepo): Response
    {
        return $this->render('admin/picture/admin-picture.html.twig', [
            'pictures' => $picRepo->findBy(array(),array('pictureOrder'=>'asc')),
        ]);
    }
    #[Route('/admin/picture/create', name: 'admin-picture-create')]
    public function pictureCreate(SluggerInterface $slugger, Request $request, ManagerRegistry $doctrine): Response
    {
        $pic = new Photo();
        $form = $this->createForm(PictureFormType::class, $pic);
        $form->handleRequest($request);

        $picfile = $form->get('picture')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($picfile) {
                $originalFilename = pathinfo($picfile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picfile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picfile->move(
                        $this->getParameter('picture_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $pic->setPicture($newFilename);

                $em = $doctrine->getManager();
                $em->persist($pic);
                $em->flush();

                $pic->setPicture(
                    new File($this->getParameter('picture_directory').'/'.$pic->getPicture())
                );
            return $this->redirectToRoute('admin-picture');
            }

            // ... persist the $product variable or any other work

        return $this->render('admin/picture/admin-picture-create.html.twig', [
            'pictureForm' => $form->createView(),
        ]);
    }

    #[Route('/admin/picture/edit/{id}', name: 'admin-picture-modifier')]
    public function PictureEdit(ManagerRegistry $doctrine, $id, SluggerInterface $slugger, Request $request)
    {

        $picRepo = $doctrine->getRepository(Photo::class);
        $pic = $picRepo->findOneBy(['id'=>$id]);
        $form = $this->createForm(PictureFormType::class, $pic);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $picFile = $form->get('picture')->getData();

            // this condition is needed because the 'brochure' field is not required
            // so the PDF file must be processed only when a file is uploaded
            if ($picFile) {
                $originalFilename = pathinfo($picFile->getClientOriginalName(), PATHINFO_FILENAME);
                // this is needed to safely include the file name as part of the URL
                $safeFilename = $slugger->slug($originalFilename);
                $newFilename = $safeFilename.'-'.uniqid().'.'.$picFile->guessExtension();

                // Move the file to the directory where brochures are stored
                try {
                    $picFile->move(
                        $this->getParameter('picture_directory'),
                        $newFilename
                    );
                } catch (FileException $e) {
                    // ... handle exception if something happens during file upload
                }

                // updates the 'brochureFilename' property to store the PDF file name
                // instead of its contents
                $pic->setImage($newFilename);

                $em = $doctrine->getManager();
                $em->persist($pic);
                $em->flush();
            }
            return $this->redirectToRoute('admin-picture');
        }
        
        return $this->render('admin/picture/admin-picture-edit.html.twig', [
            'pictureForm' => $form->createView()
        ]);
    }
    #[Route('/admin/pricture/delete/{id}', name: 'admin-picture-delete')]
        public function PictureDelete(Photo $picture, ManagerRegistry $doctrine): RedirectResponse
        {
            $em = $doctrine->getManager();
            $em->remove($picture);
            $em->flush();

        return $this->redirectToRoute("admin-picture");
        }

    #[Route('/admin/picture/{id}/{move}', name: 'admin-picture-move')]
    public function PictureMouve(ManagerRegistry $doctrine, $move, $id){

        $em = $doctrine->getManager();
        $picRepo = $doctrine->getRepository(Photo::class);
        $picture = $picRepo->findOneBy(array('id'=>$id)); 

        if($picture->getPictureOrder()==null){
            $picture->setPictureOrder(0);
        }
        if($move=='haut'){
            $position=$picture->getPictureOrder();
            if($position!=0){
                $position = $position-1;
            }  
        }
        if($move=='bas'){
            $position = $picture->getPictureOrder();
            if($position!=0){
                $position = $position+1;
            }
        }
        $pictureInvers = $picRepo->findOneBy(array('pictureOrder'=>$position));
        if($pictureInvers){
            $pictureInvers->setPictureOrder($picture->getPictureOrder());
            $em->persist($pictureInvers);
        }
        $picture->setPictureOrder($position);
        
        $em->persist($picture);
        $em->flush();
        
        return $this->redirectToRoute('admin-picture');
    }
}
