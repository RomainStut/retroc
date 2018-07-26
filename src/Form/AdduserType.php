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
            ->add("users", UserType::class, array('data_class' => Users::class, "label" => false))
            ->add('plainPassword',RepeatedType::class, array('type'=> PasswordType::class, 'invalid_message' => 'les mdp ne sont pas identiques',
                'first_options' => ['label' => 'Mot de passe'],
                'second_options' => ['label' => 'Répétez le mot de passe']))
            ->add("S'inscrire", SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {

        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
