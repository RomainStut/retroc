<?php

namespace App\Form;

use App\Entity\Users;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        for($i=date('Y');$i>=1900; $i--){
            $years[] = $i;
        }

        $builder
            ->add('username', TextType::class, array('label' => 'Pseudonyme'))
            ->add('email', EmailType::class, array('label' => 'Adresse email'))
            ->add('tel', TelType::class, array('label' => 'Numéro de téléphone'))
            ->add('datebirth', DateType::class, array(
                'label'=>'Date de naissance',
                'years'=>$years
            ))
            ->add('address', TextType::class, array('label' => 'Adresse'))
            ->add('codepostal', IntegerType::class, array('label' => 'Code postal'))
            ->add('city', TextType::class, array('label' => 'Ville'))
            ->add('plainPassword',RepeatedType::class, array('type'=> PasswordType::class, 'invalid_message' => 'les mdp ne sont pas identiques',
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répétez le mot de passe']))
            ->add('s\'inscrire', SubmitType::class, array('label'=>'s\'inscrire', 'attr' => ['class' => 'btn btn-info']));
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
