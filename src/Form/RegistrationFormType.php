<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', EmailType::class,[
                "attr" => [
                    "placeholder" => "Entrez votre email",
                    "class" => "form-control"
                ]
            ])
            ->add('RGPDConsent', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => 'You should agree to our terms.',
                    ]),
                ],
                'label' => "En m'inscrivant à ce site j'accepte les conditions général"
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'La confirmation du mot de passe n\'est pas valide',
                'options' => ['attr' => ['class' => 'password-field']],
                'required' => true,
                'mapped' => false,
                'first_options'  => [
                    'label' => 'Mot de passe',
                    'attr' => [
                    "placeholder" => "8 caractères",
                        ],   
                ],
                'second_options' => [
                    'label' => 'Confirmation du mot de passe',
                    'attr' => [
                    "placeholder" => "8 caractères",
                    ], ],
                'attr' => ['autocomplete' => 'new-password',
                "placeholder" => "8 caractères",
                "class" => "form-control"
                    ],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Il vous faut un mot de passe',
                    ]),
                    new Length([
                        'min' => 8,
                        'minMessage' => 'Votre mot de passe doit contenir au moins {{ limit }} caractères. Veuillez en saisir un plus long.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('nom', TextType::class, [
                "label" => "Nom",
                "required" => false,
                "attr" => [
                    "placeholder" => "Entrez votre nom",
                    "class" => "form-control"
                ]
            ])
            ->add('prenom', TextType::class, [
                "label" => "Prénom",
                "required" => false,
                "attr" => [
                    "placeholder" => "Entrez votre prénom",
                    "class" => "form-control"
                ]
            ])
            ->add('adresse', TextType::class, [
                "label" => "Adresse",
                "required" => false,
                "attr" => [
                    "placeholder" => "ex:11 rue du général",
                    "class" => "form-control"
                ]
            ])
            ->add('cp', NumberType::class, [
                "label" => "Code postal",
                "required" => false,
                "attr" => [
                    "placeholder" => "ex:75000",
                    "class" => "form-control"
                ]
            ])
            ->add('tel', TelType::class, [
                "label" => "Téléphone",
                "required" => false,
                "attr" => [
                    "placeholder" => "ex:0000000000",
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
