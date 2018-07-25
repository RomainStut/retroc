<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Users;

class UserController extends Controller
{
    /**
     * @Route("/user", name="user")
     */
    public function index()
    {
        return $this->render('user/index.html.twig', [
            'controller_name' => 'UserController',
        ]);
    }
    /**
     * @Route("/profil", name="userProfil")
     */
    public function showUser()
    {

    	$this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
    	$userId = $this->getUser();

        $repository = $this->getDoctrine()->getRepository(Users::class);
        $user = $repository->find($userId);       
        // nous permet de renvoyer un message d'erreur si aucun id ne correspond
        if(!$user){
            throw $this->createNotFoundException('No user found for id '.$id);
        }
         	return $this->render('user/infoUser.html.twig', array('user'=>$user));
    }
}
