<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContactController extends Controller
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index()
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }

    public function contactmail(\Swift_Mailer $mailer)
    {
        $confirmMessage="";
        $errorMessage="";
        if ($_POST) {

            $nom= $_POST['nom'];
            $sujet= $_POST['sujet'];
            $email= $_POST['email'];
            $message= $_POST['message'];

            $message = (new \Swift_Message('Contact Octocote'))
                ->setFrom($_POST['email'])
                ->setTo('octocote@gmail.com')
                ->setBody(
                    $this->renderView(
                    // templates/emails/registration.html.twig
                        'contact/mail.html.twig',
                        ['nom'=>$nom, 'sujet'=>$sujet, 'email'=>$email, 'message'=>$message]
                    ),
                    'text/html'

                )

            ;
            if ($mailer->send($message)) {
                $this->addFlash('success', 'Message envoyé');
                return $this->redirectToRoute('contact');
            }else{
                $this->addFlash('danger', 'Erreur lors de l\'envoi');
                return $this->redirectToRoute('contact');
            }

        }



        return $this->render('contact/index.html.twig', [
            'success'=>$confirmMessage, 'error'=>$errorMessage
        ]);
    }

}

