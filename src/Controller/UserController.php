<?php

namespace App\Controller;

use App\Form\UpdateUserType;
use App\Form\UserType;

use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Entity\Users;
use Symfony\Component\HttpFoundation\Session\Session;
use App\Entity\Messages;


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
     * @route("/profil/update/{id}", name="updateUser", requirements= {"id"="\d+"})
     */
    public function updateUser(Users $users, Request $request, FileUploader $uploader)
    {
        $fileName = $users->getProfilepicture();
        if($users->getProfilepicture()) {
            //pour povoir générer le formulaire, on doit transformer le nom du fichier stocké pour l'instant
            // dans l'attribut image en instance de la classe File (ce qui est attendu par le formulaire)
            $users->setProfilepicture(new File($this->getParameter('articles_image_directory') . '/' . $users->getProfilepicture()));
        }
        $form = $this->createForm(UpdateUserType::class, $users);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $users = $form->getData();

            if($users->getProfilepicture()){

                $file = $users->getProfilepicture();

                $fileName = $uploader->upload($file, $fileName);

                }
            $users->setProfilepicture($fileName);
            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            $this->addFlash('success', 'Profil modifié !');
            return $this->redirectToRoute('userProfil');
        }
        return$this->render('user/modifUser.html.twig', array('form' => $form->createView()));
    }

    /**
     * @Route("profil/delete/user/{id}", name="delete-user-profil", requirements= {"id"="\d+"})
     */
    public function deleteUserProfil(Users $user)
        {

            $currentUserId = $this->getUser()->getId();


                $session = $this->get('session');
                $session = new Session();
                $session->invalidate();


            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->remove($user);

            $entityManager->flush();

            //$this->addFlash('success', 'Votre profil a bien été supprimé! A bientôt sur Octocote!');

            return $this->redirect('/?message=Votre profil a bien été supprimé! A bientôt sur Octocote!');

        }
}
