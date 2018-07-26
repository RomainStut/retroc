<?php

namespace App\Controller;

use App\Form\UserType;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Users;
use App\Entity\Messages;



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
     * @route("profil/modifier", name="modifUser")
     */
    public function updateUser(Users $users, Request $request, FileUploader $uploader)
    {
        $fileName = $users->getImage();
        if($users->getImage()) {
//pour povoir générer le formulaire, on doit transformer le nom du fichier stocké pour l'instant
            // dans l'attribut image en instance de la classe File (ce qui est attendu par le formulaire)
            $users->setImage(new File($this->getParameter('articles_image_directory') . '/' . $users->getImage()));
        }

        $form = $this->createForm(UserType::class, $users);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $category = $form->getData();
            if ($users->getImage()){
                //on récupère un objet de classe File
                $file = $users->getImage();

                $fileName = $uploader->upload($file, $fileName);
            }
            $users->setImage($fileName);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->flush();
            $this->addFlash('success', 'Utilisateur modifiée !');
            return $this->redirectToRoute('userProfil');

        }
        return$this->render('user/modifUser.html.twig', array('form' => $form->createView()));
    }
    /**
    *@Route("/profil/message", name="messageUser")
    */

    public function showMessage()
    {

    	$userId = $this->getUser();

        $repository = $this->getDoctrine()->getRepository(Messages::class);
        $messages = $repository->myfindUserMessage($userId);

        //nous permet de renvoyer un message d'erreur si aucun id ne correspond
        if (!$messages) {
            throw $this->createNotFoundException(
                'No message found for user id '.$userId
            );
        }

        return $this->render('user/messageUser.html.twig',
                                array('messages' => $messages)
        );

    }

}
