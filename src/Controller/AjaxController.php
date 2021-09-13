<?php

namespace App\Controller;

use App\Repository\BlogArticleRepository;
use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AjaxController extends AbstractController
{
    /**
     * @Route("/ajax", name="ajax")
     */
    public function index(Request $request, GalleryRepository $galleryRepository, BlogArticleRepository $articleRepository, SerializerInterface $serializer)
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
        header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
        
        $table = $request->get("table");
        $tabAsso = [];
        $tabImage = $galleryRepository->listeImage();
        $tabArticle = $articleRepository->listeArticle();
        $tabAsso["tabImage"] = $tabImage;
        $tabAsso["tabArticle"] = $tabArticle;

        switch ($table) {
            case "gallery":
                
                $id = $request->get("id");
                $entityManager = $this->getDoctrine()->getManager();
                $entite = $galleryRepository->find($id);
                dump($entite);
                $nbLike = $entite->getImgLike() + 1;
                $entite->setImgLike($nbLike);
                $entityManager->flush();

                break;

            case "article":
                $id = $request->get("id");
                $entityManager = $this->getDoctrine()->getManager();
                $entite = $articleRepository->find($id);
                $nbLike = $entite->getLikeArticle() + 1;
                $entite->setLikeArticle($nbLike);
                $entityManager->flush();
                break;
        }

        $tabAssoJson = $serializer->serialize(
            $tabAsso,
            "json"
        );

        return JsonResponse::fromJsonString($tabAssoJson);

    }
//     /**
    //      * @Route("/{numeroPage}", name="json_index", methods={"GET"}, requirements={"numeroPage"="\d+"}, defaults={"numeroPage"="1"})
    //      */
    //     public function page(Request $request, GalleryRepository $galleryRepository, BlogArticleRepository $articleRepository, SerializerInterface $serializers, $numeroPage = 1) : Response
    //     {
    //         // SYMPA MAIS PAS REALISTE
    //         // $listeArticle = $articleRepository->findAll();

//         // ON NE VEUT QUE LES ARTICLES DANS LA CATEGORIE test ET TRIES PAR id DECROISSANT
    //         // $listeArticle = $articleRepository->findBy([ "category" => "test" ], [ "id" => "DESC" ]);

//         // ON NE FILTRE SUR AUCUNE COLONNE, ON NE FAIT QUE TRIER
    //         // findBy(array $criteria, array $orderBy, $limit, $offset)
    //         $quantiteParPage = 3;
    //         $indiceDepart = ($numeroPage - 1) * $quantiteParPage;
    //         // http://php.net/manual/fr/function.ceil.php
    //         $nombreTotal = $galleryRepository->count([]);
    //         $pageMax = intval(ceil($nombreTotal / $quantiteParPage));
    //         $listeArticle = $galleryRepository->findBy([], ["id" => "DESC"], $quantiteParPage, $indiceDepart);
    //         // $unArticle = $galleryRepository->findOneBy(["category" => "news"], ["id" => "DESC"]);

//         dump($nombreTotal);
    //         dump($pageMax);
    //         dump($listeArticle);
    //         dump($unArticle);
    //         dump($request->getClientIp());

//         return $this->render('article/index.html.twig', [
    //             // ON TRANSMET LA LISTE DES ARTICLES A TWIG DANS UNE VARIABLES articles
    //             // 'articles' => $listeArticle,
    //             // 'pageMax' => $pageMax,
    //             // 'numeroPage' => $numeroPage,
    // //            'articles'    => [ $unArticle ],
    //         ]);
    //     }

}
