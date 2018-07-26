<?php

namespace App\Controller;

use App\Form\UpdateUserType;
use App\Form\UserType;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\File\File;


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

    /**
     * @route("/profil/modifier/{id}", name="modif-user", requirements= {"id"="\d+"})
     */
    public function updateUser($id, Users $users, Request $request, FileUploader $uploader)
    {
//j'utilise mon voter pour déterminer si l'utilisateur peut modifier cet article
/*        $this->denyAccessUnlessGranted('edit', $users);*/


        /*$fileName = $users->getImage();
        if($users->getImage()) {
            $users->setImage(new File($this->getParameter('articles_image_directory') . '/' . $users->getImage()));
        }*/

        $form = $this->createForm(UpdateUserType::class, $users);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $users = $form->getData();
           /* if ($users->getImage()){
                //on récupère un objet de classe File
                $file = $users->getImage();

                $users = $uploader->upload($file, $fileName);
            }
            $users->setImage($fileName);*/
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur modifié !');
            return $this->redirectToRoute('userProfil');
        }


        return$this->render('user/modifUser.html.twig', array('form' => $form->createView()));
    }
}
