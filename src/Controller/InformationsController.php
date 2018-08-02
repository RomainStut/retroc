<?php

namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class InformationsController extends Controller
{
    /**
     * @Route("/informations", name="informations")
     */
    public function index()
    {
        return $this->render('informations/index.html.twig', [
            'controller_name' => 'InformationsController',
        ]);
    }

    /**
     * @Route("/informations/contact", name="contact")
     */
    public function contact(\Swift_Mailer $mailer)
    {
       $confirmMessage="";
       $errorMessage="";
       if ($_POST) {

           $nom= $_POST['nom'];
           $prenom= $_POST['prenom'];
           $sujet= $_POST['sujet'];
           $email= $_POST['email'];
           $message1= $_POST['message'];

           $message = (new \Swift_Message('Contact Octocote'))
       ->setFrom($_POST['email'])
       ->setTo('octocote@gmail.com')
       ->setBody(
           $this->renderView(
               // templates/emails/registration.html.twig
               'informations/mail.html.twig',
               ['nom'=>$nom,'prenom'=>$prenom, 'sujet'=>$sujet, 'email'=>$email, 'message'=>$message1]
           ),
           'text/html'
       );
   if ($mailer->send($message)) {
       $confirmMessage="L'email a bien été envoyé !";
   }else{
       $errorMessage="Erreur lors de l'envoi de l'email veuillez verifier vos champs.";
   }
   
       }

       return $this->render('informations/contact.html.twig', [
           'success'=>$confirmMessage, 'error'=>$errorMessage
       ]);
    }
    /**
     * @Route("/informations/cgv", name="cgv")
     */
    
    public function cgv()
    {
        return $this->render('informations/cgv.html.twig');
    }  
   
   /**
     * @Route("/informations/adress", name="adress")
     */
    
    public function adress()
    {
        return $this->render('informations/adress.html.twig');
    }

    public function contactmail(\Swift_Mailer $mailer)
    {
        
    
     
    }

    /**
     * @Route("/informations/information", name="info")
     */
    public function informationShow()
    {
        return $this->render('informations/information.html.twig');
    }

}
