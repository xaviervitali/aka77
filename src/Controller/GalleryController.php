<?php

namespace App\Controller;
use App\Entity\Artists;
use App\Commun\Upload;
use App\Entity\Gallery;
use App\Form\GalleryType;
use App\Form\GalleryEditType;
use App\Repository\GalleryRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * @Route("/admin/galerie")
 */
class GalleryController extends AbstractController
{
    /**
     * @Route("/", name="adminGalerie", methods={"GET"})
     */
    public function index(GalleryRepository $galleryRepository): Response
    {

        return $this->render('gallery/index.html.twig', [
            'galleries' => $galleryRepository->findBy([], ['dateUpdate' => 'DESC']),
        ]);
    }

// /**
//      * @Route("/{pseudo}", name="maGalerie", methods={"GET"})
//      */
//     public function maGallery(GalleryRepository $galleryRepository, Artists $artist): Response
//     {
//         return $this->render('gallery/index.html.twig', [
//             'galleries' => $galleryRepository->findBy(
//                 ['pseudo' => $artist->getPseudo()],
//                 ['dateUpdate' => 'ASC']
//             ),
//         ]);
//     }



    /**
     * @Route("/nouvelle", name="gallery_new", methods={"GET","POST"})
     */
    function new (Request $request, Upload $objMonUpload): Response {
        $gallery = new Gallery();
        $form = $this->createForm(GalleryType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // $entityManager = $this->getDoctrine()->getManager();
            // $entityManager->persist($gallery);
            // $entityManager->flush();
            // return $this->redirectToRoute('gallery_index');

            $objUploadedFile = $gallery->uploadGalleryForm;

            $dossierCible = $this->getParameter('monDossierUpload');

            $dossierThumbnails = str_replace("upload", "thumbnail", $dossierCible);
            $nomOrigine = $objMonUpload->gererUpload($objUploadedFile, $dossierCible);
            
            $extension = pathinfo($nomOrigine, PATHINFO_EXTENSION);
            $tabResol=[400,800];
            for($i=0;$i< count($tabResol);$i++){
                $objMonUpload->createThumbnail("$dossierCible/$nomOrigine", "$dossierThumbnails/$nomOrigine", $tabResol[$i]);
            };
           
            $imageSmall = str_replace(".$extension", "_400.$extension", $nomOrigine );
            $imageMedium = str_replace(".$extension", "_800.$extension", $nomOrigine);


            // dump($thumbnail);
            if ($nomOrigine != "") {
                $gallery->setUrlImgOriginal("assets/img/upload/$nomOrigine");
                $gallery->setDateUpdate(new \Datetime);
                $gallery->setImgLike(0);
                $gallery->setImgSmall("assets/img/thumbnail/$imageSmall");
                $gallery->setImgMedium("assets/img/thumbnail/$imageMedium");

                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($gallery);
                $entityManager->flush();
                $messageForm = "Votre image est maintenant publiée";
            } else {
                $messageForm = "ERREUR SUR LE FICHIER UPLOAD";
            }
            return $this->redirectToRoute('gallery_new');
        }
        return $this->render('gallery/new.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }


    /**
     * @Route("/{id}", name="gallery_show", methods={"GET"})
     */
    public function show(Gallery $gallery): Response
    {
        return $this->render('gallery/show.html.twig', [
            'gallery' => $gallery,
        ]);
    }


    /**
     * @Route("/{id}/edit", name="gallery_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Gallery $gallery): Response
    {
        $form = $this->createForm(GalleryEditType::class, $gallery);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
        
            return $this->redirectToRoute('adminGalerie', [
                'id' => $gallery->getId(),
            ]);
        }

        return $this->render('gallery/edit.html.twig', [
            'gallery' => $gallery,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="gallery_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Gallery $gallery): Response
    {
        if ($this->isCsrfTokenValid('delete' . $gallery->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($gallery);
            $entityManager->flush();
        }

        return $this->redirectToRoute('adminGalerie');
    }

    /**
     * @Route("/", name="maGalerie", methods={"GET"})
     */
        public function maGalerie(GalleryRepository $galleryRepository): Response
    {

        return $this->render('gallery/index.html.twig', [
            'galleries' => $galleryRepository->findBy( array('id' => $id->getId()), array('id' => 'DESC')),
        ]);
    }
}
