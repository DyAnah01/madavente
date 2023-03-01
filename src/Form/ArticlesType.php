<?php

namespace App\Form;

use App\Entity\Articles;
use App\Entity\Categorie;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class ArticlesType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('titre', TextType::class, [
                'label' => "Titre",
                'required' => false,
                'attr' => [
                    'placeholder' => "Le titre de l'article",
                    'class' => "form-control"
                ]
            ])
            ->add('description', TextType::class,[
                'label' => "Description",
                'required' => false,
                'attr' => [
                    'placeholder' => "Décrire l'article",
                    'class' => "form-control",
                ]               
            ])
            ->add('images', FileType::class, [
                'label' => 'Photo',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '1024k',
                        'mimeTypes' => [
                            'image/png',
                            'image/jpeg',
                        ],
                        'mimeTypesMessage' => 'Veuillez Importer une image valide',
                    ])
                ],
                'attr' => [
                    'placeholder' => "Importer l'image de l'article",
                    'class' => "form-control",
                ]
            ])
            ->add('prix', NumberType::class,[
                'label' => "Prix",
                'required' =>  false,
                'attr' => [
                    'placeholder' => "Le prix de l'article",
                    'class' => 'form-control'
                ]
            ])
            // ->add('dateCreation')
            ->add('stock', NumberType::class,[
                'label' => "Stock",
                'required' =>  false,
                'attr' => [
                    'placeholder' => "Quantité disponible",
                    'class' => 'form-control',
                ]
                ])
            ->add('shortDescription', TextType::class,[
                'label' => "Courte description",
                'required' => false,
                'attr' => [
                    'placeholder' => "Décrire brievement l'article",
                    'class' => "form-control",
                ] 
            ])
            ->add('idCategorie', EntityType::class, [
                'class' => Categorie::class,
                'placeholder' => 'Selecionner une categorie',
                'choice_label' => 'nom',
                'label' => 'Catégorie',
                'required' => false,
                'attr' => [
                    'class' => "form-control",
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Articles::class,
        ]);
    }
}
