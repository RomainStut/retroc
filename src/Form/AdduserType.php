<?php

namespace App\Form;

use App\Entity\Users;
use App\Form\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class AdduserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("users", UserType::class, array('data_class' => Users::class, "label" => true))
            ->add('plainPassword',RepeatedType::class, array('type'=> PasswordType::class, 'invalid_message' => 'le mot de passe n\'est pas identique',
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répétez le mot de passe']))
            ->add("Inscription", SubmitType::class, array('label'=>'Inscription', 'attr' => ['class' => 'navbarColor01 text-warning']))
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
