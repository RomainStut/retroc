<?php

namespace App\Controller;

use App\DataFixtures\TestData;
use App\Entity\Tokenresetpassword;
use App\Form\AdduserType;
use App\Form\ResetPassword1Type;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\Users;
use App\Form\UserType;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\User\User;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class SecurityController extends Controller
{


    /**
    *@Route("/register/", name="register")
    */

    public function register(Request $request, UserPasswordEncoderInterface $encoder){

        $user = new Users();

        $form = $this->createForm(AdduserType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $user = $form->getData();

            $mdpEncoded = $encoder->encodePassword($user, $user->getPlainPassword());

//            dump($mdpEncoded);
//            dump($user->getPlainPassword());
            $user->setPassword($mdpEncoded);

            $user->eraseCredentials();
//            dump($user);

            $user->setRoles(array('ROLE_USER'));

            $entityManager = $this->getDoctrine()->getManager();

            $entityManager->persist($user);

            $entityManager->flush();

             $this->addFlash(
                'success',
                'Vous êtes bien inscrit, vous pouvez vous connecter !'
            );

            return $this->redirectToRoute('login');


        }


        return $this->render('security/register.html.twig', array(
            'form' => $form->createView()
        ));


    }

    /**
     * @Route("/register/reset", name="reset-password")
     */

    public function searchBarReset(Request $request, \Swift_Mailer $mailer)
    {
        $form = $this->createFormBuilder(null)
            ->add('Email', EmailType::class)
            ->add('Envoyer', SubmitType::class, ['attr' => ['class' => 'btn text-warning navbarColor01 ']])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $search = $request->request->get('form');

            $email = $form->get('Email')->getData();

//            dump($email);

            $repository = $this->getDoctrine()->getRepository(Users::class);

            $user = $repository->findOneBy(['email'=>$email]);

//            dump($user);

            if($user){

                $token = md5(uniqid(rand(), true));

                $reset =new Tokenresetpassword();

                $reset->setToken($token);
                $reset->setUser($user);

                $em = $this->getDoctrine()->getManager();
                $em->persist($reset);
                $em->flush();

                $id_user = $user->getId();

                $message = (new \Swift_Message('Reset Mot de Passe'))
                    ->setFrom('octocote@gmail.com')
                    ->setTo($email)
                    ->setBody(
                        $this->renderView(
                            'security/mailreset.html.twig',
                            array('token' => $token, 'idUser' => $id_user, 'user'=>$user)
                        ),
                        'text/html'
                    );
            }
            if ($mailer->send($message)) {
                $this->addFlash('success', "L'email de réinitialisation a bien été envoyé. Veuillez consulter votre boîte mail.");
            }else{
                $this->addFlash('danger',"Erreur lors de l'envoi de l'email veuillez verifier votre adresse email.");
            }

        }else{
            $this->addFlash('primary alert',"Veuillez saisir votre email pour recevoir le lien de réinitialisation");
        }

        return $this->render('security/reset-password.html.twig', array('form' => $form->createView()));
    }



    /**
     * @Route("/register/reset-motdepasse", name="reset")
     */

    public function reset (Request $request){

        $token = $request->query->get('token', null);

        $iduser = $request->query->get('idUser', null);

        if(!$token || !$iduser){
            //token et id incorrects donc redirectionner
            $this->addFlash('danger',"Erreur!! parametres invalides");
            return $this->redirectToRoute('reset-password');
        }

        //verifier que le token et le user id existe dans ma bdd
        $repository=$this->getDoctrine()->getRepository(Tokenresetpassword::class);
        $resetPassword = $repository->findOneBy(['token'=>$token]);

        if(!$resetPassword){
            //token et id incorrects donc redirectionner
            $this->addFlash('danger',"Erreur!! Parametres invalides");
            return $this->redirectToRoute('reset-password');
        }

        return $this->render('security/newpassword.html.twig', array('idUser'=>$iduser) );
    }

    /**
     * @Route("register/newpassword", name="newmdp")
     */
    public function getNewPassword(Request $request, UserPasswordEncoderInterface $encoder)
        {
            $form = $this->createFormBuilder(null)
                ->add('plainPassword',RepeatedType::class, array('type'=> PasswordType::class, 'invalid_message' => 'Erreur, les deux mots de passe ne sont pas identiques.',
                    'first_options' => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Répétez le mot de passe']))
                ->add('Valider votre nouveau mot de passe', SubmitType::class, ['attr' => ['class' => 'btn text-warning navbarColor01 ']])
                ->getForm();

            $form->handleRequest($request);

            if($form->isSubmitted() && $form->isValid()){

                $password = $form->getData();

                $idUser = $request->query->get('idUser');

                $user = $this->getDoctrine()->getRepository(Users::class )->find($idUser);

                if($user){
                    $mdpEncoded = $encoder->encodePassword($user, $password['plainPassword']);
                }



                if($password){
                    $repository=$this->getDoctrine()->getRepository(Users::class);
                    $user=$repository->find($idUser);

                    if($user){
                        $user->setpassword($mdpEncoded);
                        $entityManager = $this->getDoctrine()->getManager();
                        $entityManager->persist($user);
                        $entityManager->flush();
                        $this->addFlash('success', "Votre mot de passe a été modifié! Connectez vous.");
                    }else{
                        $this->addFlash('danger',"Le mot de passe n'a pa pu être modifié");
                    }
                }

                return $this->redirectToRoute('login');

            }

            return $this->render('security/success-mdp-modifier.html.twig', array(
                'form' => $form->createView()));
        }

}
