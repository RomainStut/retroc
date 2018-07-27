<?php

namespace App\Controller;
use App\Entity\Products;
use App\Form\AdduserType;
use App\Form\UpdateUserType;
use App\Form\UserType;
use App\Service\FileUploader;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\File\File;

class AdminController extends Controller
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index()
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }
    /**
     * @route("/admin/users", name="admin-users")
     */
    public function findAll()
    {
        $repository = $this->getDoctrine()->getRepository(Users::class);

        $users = $repository->findAll();

        return $this->render('admin/gestionUsers.html.twig',
            array('users' =>$users));

    }

    /**
     * @Route("/admin/users/delete/{id}", name="delete-user", requirements={"id", "\d+"})
     */
    public function deleteUser(Users $user)
    {

        $entityManager = $this->getDoctrine()->getManager();

        $entityManager->remove($user);

        $entityManager->flush();

        //créerun message flash et renvoyer sur la liste des dernieres categorie
        $this->addFlash('danger', 'Utilisateur Supprimé! ');

        return $this->redirectToRoute('admin-users');

    }

    /**
     * @Route("/admin/users/update/{id}", name="update-user", requirements={"id", "\d+"})
     */
    public function updateUser(Users $users, Request $request, FileUploader $uploader){



        $fileName = $users->getProfilepicture();
        if($users->getProfilepicture()) {

            $users->setProfilepicture(new File($this->getParameter('articles_image_directory') . '/' . $users->getProfilepicture()));
        }

        $form = $this->createForm(UpdateUserType::class, $users);




        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isvalid()){

            $users = $form->getData();

            if($users->getProfilepicture()){

                $file = $users->getProfilepicture();

                $fileName = $uploader->upload($file, $fileName);

                $users->setProfilepicture($fileName);
            }


            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            $this->addFlash('info', 'L\'utilisateur a bien été modifié');

            return $this->redirectToRoute('admin-users');
        }

        return $this->render('/admin/update.html.twig', array('form' => $form->createView()));

    }

    /**
     * @Route("/admin/validation", name="validation-annonce")
     */
    public function showInvalid()
    {
        $repository = $this->getDoctrine()->getRepository(Products::class);

        $products = $repository->findInvalid();

        return $this->render('admin/gestionAnnonces.html.twig',
            array('products' => $products));

    }

}
