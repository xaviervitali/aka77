<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Gallery;
use App\Entity\Artists;
use App\Form\ArtistsType;
use App\Repository\ArtistsRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {

//     $user = $this->getUser();

//         if (null === $user) {
// $objetResponse = $this->render('public/home.html.twig');
//         return $objetResponse;

//         }
//         else if($user === 'admin'){
//                     return $this->render('admin/index.html.twig', [
//             'controller_name' => 'AdminController',
//         ]);
//         }
//         else{
// return $this->render('profile/index.html.twig', [
//             'controller_name' => 'AdminController',
//  ]); }
return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);

        }

}
