<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Validator\Constraints\IsTrue;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', TextType ::class, [
                'label' => 'Email',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('firstname', TextType ::class, [
                'label' => 'Prénom',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('name', TextType ::class, [
                'label' => 'Nom',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'mapped' => false,
                'constraints' => [
                    new IsTrue([
                        'message' => "Vous n'avez pas accepté les CGU.",
                    ]),
                ],
                'attr'=>[
                    'class'=>'form-check-input'
                ],
            ])
            ->add('plainPassword', PasswordType::class, [
                // instead of being set onto the object directly,
                // this is read and encoded in the controller
                'label' => 'Mot de passe',
                'mapped' => false,
                'attr' => [
                    'autocomplete' => 'new-password',
                    'class'=>'form-control'
                ],

                'constraints' => [
                    new NotBlank([
                        'message' => "Veuillez entrer un mot de passe.",
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit faire au minimum {{ limit }} caractères',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('role', ChoiceType::class, [
                'label'=>"M'inscrire en tant que: ",
                'mapped'=>false,
                'attr'=>[
                    'class'=>'form-select'
                ],
                'choices'=>[
                    'Vendeur'=>'ROLE_SELLER',
                    'Acheteur'=>'ROLE_USER',
                ],
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
