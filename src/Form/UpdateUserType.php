<?php

namespace App\Form;

use App\Entity\Users;
use App\Form\UserType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class UpdateUserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add("users", UserType::class, array('data_class' => Users::class))
            ->add('profilepicture', FileType::class, array('label'=>'ajoutez une image', 'required'=> false))
            ->add(" modifier", SubmitType::class, array('label'=>'Modifier', 'attr' => ['class' => 'btn btn-dark']))

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Users::class,
        ]);
    }
}
