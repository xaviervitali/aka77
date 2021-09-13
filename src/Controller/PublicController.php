<?php

namespace App\Controller;

use App\Entity\Artists;
use App\Entity\BlogArticle;
use App\Entity\Gallery;
use App\Repository\ArtistsRepository;
use App\Repository\BlogArticleRepository;
use App\Repository\ContactRepository;
use App\Repository\GalleryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\Query\ResultSetMapping;

class PublicController extends AbstractController
{
    /**
     * @Route("/" , name="home")
     */
    public function home(ArtistsRepository $artistsRepository, BlogArticleRepository $article): Response
    {
        $listeArtists = $artistsRepository->findAll([], ["dateCreation" => "DESC"]);
        $articles = $article->findAll(['id' => "DESC"]);
        $dernierArticle = $articles[count($articles) - 1];
        $objetResponse = $this->render('public/home.html.twig', [

            'users' => $listeArtists,
            'article' => $dernierArticle,

        ]);
        return $objetResponse;
    }

    /**
     * @Route("/legacy" , name="legacy")
     */
    public function legacy(): Response
    {

        $objetResponse = $this->render('public/legacy.html.twig');
        return $objetResponse;
    }

    /**

     * @Route("/galerie", name="galerie", methods={"GET"})

     */

    public function gallery(GalleryRepository $galleryRepository): Response
    {

        $listeGallery = $galleryRepository->findBy([], ["dateUpdate" => "DESC"]);


        // $requete->setParameter(1, 'romanb');

        $listeArtistes = $galleryRepository->findAllArtist();

        return $this->render('public/gallery.html.twig', [

            'gallerys' => $listeGallery,
            'listeArtiste' => $listeArtistes,

        ]);
    }

    /**
     * @Route("/artistes", name="artistes", methods={"GET"})
     */
    public function user(ArtistsRepository $artistsRepository): Response
    {
        $listeArtists = $artistsRepository->findAll([], ["dateCreation" => "DESC"]);

        return $this->render('public/artistes.html.twig', [

            'users' => $listeArtists,

        ]);
    }

    /**
     * @Route("/contact", name="contact", methods={"GET"})
     */
    public function contact(ContactRepository $contactRepository): Response
    {
        return $this->render('public/contact.html.twig');
    }

    /**
     * @Route("/blog{numberPage}", name="blog", methods={"GET"},requirements={"numberPage"="\d+"}, defaults={"numeroPage"="1"})
     */
    public function blog(BlogArticleRepository $blogArticleRepository, $numberPage = 1): Response
    {
        /*  $listeArticle = $articleRepository->findBy(["category" => "actu"], ["datePublication" => "DESC"]);*/
        $quantityPage = 3;
        $indexStart = ($numberPage - 1) * $quantityPage;
        $nombreTotal = $blogArticleRepository->count([]);
        $pageMax = intval(ceil($nombreTotal / $quantityPage));
        $listeArticle = $blogArticleRepository->findBy([], ["dateModification" => "DESC"], $quantityPage, $indexStart);
        return $this->render('public/blog.html.twig', [
            'articles' => $listeArticle,
            'pageMax' => $pageMax,
            'numberPage' => $numberPage,
        ]);
    }

    /**
     * @Route("/article", name="article", methods={"GET"})
     */
    public function article(BlogArticleRepository $blogArticleRepository): Response
    {

        return $this->render('public/article.html.twig', [
            'article' => $blogArticle,
            'articles' => $listeArticle,

        ]);
    }

    /**
     * @Route("/blog/{urlArticle}", name="article_show_url", methods={"GET"})
     */
    public function showUrlArticle(BlogArticle $blogArticle): Response
    {

        return $this->render('public/article.html.twig', [
            'article' => $blogArticle,

        ]);
    }

    /**
     * @Route("/recherche", name="recherche", methods={"GET"})
     */
    public function recherche(BlogArticleRepository $blogArticleRepository): Response
    {

        return $this->render('public/recherche.html.twig');

        $articleFooter = $blogArticleRepository->findBy(["category" => "footer"], ["datePublication" => "DESC"]);
        return $this->render('public/recherche.html.twig', [
            'articleFooter' => $articleFooter,
        ]);
    }

    /**
     * @Route("/artiste", name="artiste", methods={"GET"})
     */
    public function artists(ArtistsRepository $artistsRepository): Response
    {
        $listeArtists = $artistsRepository->findBy([], ["dateCreation" => "DESC"]);
        return $this->render('public/artiste.html.twig', [
            'user' => $artists,
            'users' => $listeArtists,

        ]);
    }

    /**
     * @Route("/artist/{urlPageArtist}", name="artiste_show_url", methods={"GET"})
     */
    public function showUrlArtists(Artists $artists, GalleryRepository $gallery): Response
    {

        // $gallery = new Gallery;

        $pseudoArtiste = $artists->getPseudo();
        $imageArtiste = $gallery->findBy(['Artist' => $pseudoArtiste]);
        return $this->render('public/artiste.html.twig', [

            'user' => $artists,
            'gallery' => $imageArtiste,

        ]);
    }

    /**
     * @Route("/team" , name="team")
     */
    public function team()
    {

        $objetResponse = $this->render('public/team.html.twig');
        return $objetResponse;
    }
}
