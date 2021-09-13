<?php

namespace App\Controller;

use App\Commun\Upload;
use App\Entity\BlogArticle;
use App\Form\BlogArticleEditType;
use App\Form\BlogArticleType;
use App\Repository\BlogArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/blog")
 */
class BlogArticleController extends AbstractController
{
 /**
  * @Route("/", name="adminBlog", methods={"GET"})
  */
 public function index(BlogArticleRepository $blogArticleRepository): Response
 {
  return $this->render('blog_article/index.html.twig', [
   'blog_articles' => $blogArticleRepository->findBy([], ['dateModification' => 'DESC']),
  ]);
 }

/**
 * @Route("/new", name="blog_article_new", methods={"GET","POST"})
 */
 function new (Request $request, Upload $objMonUpload): Response {

  $blogArticle = new BlogArticle();

  $form = $this->createForm(BlogArticleType::class, $blogArticle);

  $form->handleRequest($request);

  if ($form->isSubmitted()
   && $form->isValid()) {

   $objUploadedFile = $blogArticle->getBlogImg();
   $dossierCible = $this->getParameter('monDossierUpload');

   $nomOrigine = $objMonUpload->gererUpload($objUploadedFile, $dossierCible);

   if ($nomOrigine != "") {

    $blogArticle->setBlogImg("assets/img/upload/$nomOrigine");

    $blogArticle->setDateModification(new \DateTime);
    $blogArticle->setLikeArticle(0);
    $entityManager = $this->getDoctrine()->getManager();
    $entityManager->persist($blogArticle);
    $entityManager->flush();

    $messageForm = "Votre article est maintenant publié";

   } else {

    $messageForm = "ERREUR SUR LE FICHIER UPLOAD";
   }
   return $this->redirectToRoute('adminBlog');
  }
  return $this->render('blog_article/new.html.twig', [
   'blogArticle' => $blogArticle,
   'form' => $form->createView(),
  ]);
 }

/**
 * @Route("/{id}", name="blog_article_show", methods={"GET"})
 */
 public function show(BlogArticle $blogArticle): Response
 {
  return $this->render('blog_article/show.html.twig', [
   'blog_article' => $blogArticle,
  ]);
 }

/**
 * FORMULAIRE D'EDITION DES ARTICLES
 *
 * @Route("/{id}/edit", name="blog_article_edit", methods={"GET","POST"})
 */
 public function edit(Request $request, BlogArticle $blogArticle, Upload $objMonUpload): Response
 {
  $form = $this->createForm(BlogArticleEditType::class, $blogArticle);
  $form->handleRequest($request);
  dump($blogArticle);
  if ($form->isSubmitted() && $form->isValid()) {

   // propriété pour gérer upload optionnel
   $objUploadedFile = $blogArticle->getUploadBlogImg();

   // SI LE CHAMP D'UPLOAD N'EST PAS NUL, ON VA ACCEPTER LE FICHIER UPLOADE
   if ($objUploadedFile != null) {
    $dossierCible = $this->getParameter('monDossierUpload');
    $nomOrigine = $objMonUpload->gererUpload($objUploadedFile, $dossierCible);
    // on synchronise la database avec le bon chemin
    $blogArticle->setBlogImg("assets/img/upload/$nomOrigine");
   }

   // SI LE CHAMP D'UPLOAD EST NUL, JE CONTINUE LE PROCESSUS, DONC CA GARDE L'IMAGE DEJA UPLOADEE
   $this->getDoctrine()->getManager()->flush();

   return $this->redirectToRoute('adminBlog', [
    'id' => $blogArticle->getId(),
   ]);
  }

  return $this->render('blog_article/edit.html.twig', [
   'blog_article' => $blogArticle,
   'form' => $form->createView(),
  ]);
 }

 /**
  * @Route("/{id}", name="blog_article_delete", methods={"DELETE"})
  */
 public function delete(Request $request, BlogArticle $blogArticle): Response
 {
  if ($this->isCsrfTokenValid('delete' . $blogArticle->getId(), $request->request->get('_token'))) {
   $entityManager = $this->getDoctrine()->getManager();
   $entityManager->remove($blogArticle);
   $entityManager->flush();
  }

  return $this->redirectToRoute('adminBlog');
 }
}
