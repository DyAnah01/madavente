<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class, [
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('nom', TextType::class, [
                "label" => "Nom",
                "required" => false,
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('prenom', TextType::class, [
                "label" => "Prénom",
                "required" => false,
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('tel', TelType::class, [
                "label" => "Téléphone",
                "required" => false,
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('adresse', TextType::class, [
                "label" => "Adresse",
                "required" => false,
                "attr" => [
                    "class" => "form-control"
                ]
            ])
            ->add('cp', NumberType::class, [
                "label" => "Code postal",
                "required" => false,
                "attr" => [
                    "class" => "form-control"
                ]
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
