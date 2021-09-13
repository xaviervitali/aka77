<?php

namespace App\Controller;

use App\Entity\Artists;
use App\Form\ArtistsType;
use App\Repository\ArtistsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Commun\Upload;

/**
 * @Route("/admin/artistes")
 */
class ArtistsController extends AbstractController
{
    /**
     * @Route("/", name="adminArtistes", methods={"GET"})
     */
    public function index(ArtistsRepository $artistsRepository): Response
    {
        return $this->render('artists/index.html.twig', [
            'artists' => $artistsRepository->findAll(),
        ]);
    }

    /**
     * @Route("/nouveau", name="artists_new", methods={"GET","POST"})
     */
    public function new(Request $request, Upload $objMonUpload): Response
    {
        $artist = new Artists();
        $form = $this->createForm(ArtistsType::class, $artist);
        $form->handleRequest($request);
		dump($request);
        if ($form->isSubmitted() && $form->isValid()) {
            
            $artist->setDateCreation(new \DateTime);
            $artist->setDroit(3);
            $passwordNonHashe = $artist->getPassword();
            $passwordHashe = password_hash($passwordNonHashe, PASSWORD_BCRYPT);
            $artist->setPassword($passwordHashe);


    
            $objUploadedFile  = $artist->getUrlImageAvatar();
            $dossierCible = $this->getParameter('monDossierUpload');
            $nomOrigine = $objMonUpload->gererUpload($objUploadedFile, $dossierCible);

            if ($nomOrigine != "") {
            $artist->setUrlImageAvatar("assets/img/upload/$nomOrigine");
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($artist);
            $entityManager->flush();
                $messageForm = "Utilisateur creer";
                     
            }
            else
            {

                $messageForm = "ERREUR";
            }
            return $this->redirectToRoute('adminArtistes');
        }
        return $this->render('artists/new.html.twig', [
            'artist' => $artist,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="artists_show", methods={"GET"})
     */
    public function show(Artists $artist): Response
    {
        return $this->render('artists/show.html.twig', [
            'artist' => $artist,
        ]);
    }

    /**
     * @Route("/{id}/edition", name="artists_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Artists $artist): Response
    {
        $form = $this->createForm(ArtistsType::class, $artist);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('adminArtistes', [
                'id' => $artist->getId(),
            ]);
        }

        return $this->render('artists/edit.html.twig', [
            'artist' => $artist,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="artists_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Artists $artist): Response
    {
        if ($this->isCsrfTokenValid('delete'.$artist->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($artist);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adminArtistes');
    }
}
