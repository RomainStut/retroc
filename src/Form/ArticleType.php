<?php

namespace App\Form;

use App\Entity\Arcade;
use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ArticleType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('price', IntegerType::class)
            ->add('quality', CheckboxType::class)
            ->add('datepost', DateTimeType::class)
            ->add('description', TextareaType::class)
            ->add('image', FileType::class)
            ->add('categorie', EntityType::class, array('class'=>Categories::class, 'choice_label'=>'libelle'))
            ->add('Publier mon annonce', SubmitType::class, array('label'=>'Publier mon annonce', 'attr' => ['class' => 'btn btn-info']));

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Arcade::class,
        ]);
    }
}
