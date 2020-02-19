<?php

namespace App\Form;

use App\Entity\Album;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlbumType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('nom', TextType::class, [
                'label' => 'Titre de l\'album',
                'required'=> true,
                'attr' => [
                    'placeholder'=> 'Entrez-le ici !'
                ]
            ])
            ->add('pochette', TextType::class, [
                'label'=> 'Pochette de l\'album',
                'required'=> true,
                'attr' => [
                    'placeholder'=> 'Ajoutez l\'image de la pochette'
                ]
            ])
            ->add('artiste', TextType::class, [
                'label' => 'Nom de l\'artiste',
                'required'=> true,
                'attr' => [
                    'placeholder'=> 'Entrez le nom de l\'artiste'
                ]
            ])
            ->add('sorti', DateType::class, [
                'years' => range(1920,2020),
                'label' => 'Date de sortie',
                'required'=> true,
                'format' => 'dd MM yyyy',
            ])
            ->add('category', EntityType::class, [
                'class'=> Category::class,
                'choice_label'=> 'title',
                'label'=> "Quelle genre ?"
            ])
            ->add('presentation', TextareaType::class, [
                'label'=> 'Description',
                'required'=> true,
                'attr' => [
                    'placeholder'=> 'Ajoutez le détail ici…',
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Album::class,
        ]);
    }
}
