<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('email', EmailType::class, [
            'label'=> "Email",
            'required' => false,
            'constraints' => [
                new NotBlank([
                    "message" => "L'email ne doit pas être vide"
                    ]),
            ],
            "attr" => [
                "placeholder" => "Entrez votre email",
                "class" => "form-control",
                "id" => "email"
            ]
        ])
        ->add('subject', TextType::class, [
            'label'=> "Sujet",
            'required' => false,
            'constraints' => [
                new NotBlank([
                    "message" => "Le sujet ne doit pas être vide"
                    ]),
            ],
            "attr" => [
                "placeholder" => "Entrez le sujet",
                "class" => "form-control",
                "id" => "subject"
            ]
        ])
        ->add('message', TextareaType::class, [
            'label'=> "Message",
            'required' => false,
            'constraints' => [
                new NotBlank([
                    "message" => "Le message ne doit pas être vide"
                    ]),
            ],
            "attr" => [
                "placeholder" => "Entrez votre message",
                "class" => "form-control",
                "id" => "msg",
            ]
        ])
        ->add('submit', SubmitType::class, [
            'label' => 'Envoyer',
            "attr" => [
                "class" => "btn btn-outline-dark",
                "id" => "valider"
            ]
        ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
