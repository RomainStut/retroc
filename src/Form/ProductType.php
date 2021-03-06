<?php

namespace App\Form;

use App\Entity\Products;
use App\Entity\Quality;
use App\Entity\Type;
use App\Entity\Categories;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{


    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        for($i=date('Y');$i>=1900; $i--){
            $years[] = $i;
        }

        $builder            
            ->add('name', TextType::class, array('label'=>'Nom du produit'))

            ->add('quality', EntityType::class, array('class'=>Quality::class, 'choice_label'=>'name', 'required' => true))

            ->add('price', IntegerType::class, array('label'=>'Prix du produit'))
            
            ->add('type', EntityType::class, array('class'=>Type::class, 'choice_label'=>'name', 'required' => true))

            ->add('categorie', EntityType::class, array('class'=>Categories::class, 'choice_label'=>'name', 'required' => true))

            ->add('releasedate', DateType::class, array(
                'label'=>'Date de sortie',
                'years'=>$years
            ))

            ->add('description', TextareaType::class, array('label'=>'Saisissez votre annonce'))

            ->add('image', FileType::class, array('label'=>'Ajouter une image', 'required'=> false))

            ->add('publish', SubmitType::class, array('label'=>'Publier mon annonce', 'attr' => ['class' => 'navbarColor01 text-warning']));

            

        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Products::class,
        ]);
    }
}
