<?php

namespace App\Controller;
use App\Form\AdduserType;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Users;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

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
    public function updateUser(Users $users, Request $request){

        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $users = $this->getUser();

        $users = new Users();

        $form = $this->createForm(AdduserType::class, $users);

        $form->remove('plainPassword');

        $form->remove('s\'inscrire');


        $form->handleRequest($request);



        if($form->isSubmitted() && $form->isvalid()){

            $users = $form->getData();


            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->flush();

            $this->addFlash('info', 'L\'utilisateur a bien été modifié');

            return $this->redirectToRoute('admin-users');
        }

        return $this->render('/admin/update.html.twig', array('form' => $form->createView()));

    }
}
