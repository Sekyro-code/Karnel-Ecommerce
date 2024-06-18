<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\PasswordStrength;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstname',
                TextType::class,
                [
                    'label' => 'Prénom',
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(
                            min: 2,
                            minMessage: 'Votre prénom doit contenir au moins {{ limit }} caractères',
                            max: 255,
                            maxMessage: 'Votre prénom doit contenir au maximum {{ limit }} caractères',
                        ),
                    ]

                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'label' => 'Nom',
                    'constraints' => [
                        new Assert\NotBlank(),
                        new Assert\Length(
                            min: 2,
                            minMessage: 'Votre prénom doit contenir au moins {{ limit }} caractères',
                            max: 255,
                            maxMessage: 'Votre prénom doit contenir au maximum {{ limit }} caractères',
                        ),
                    ]
                ]
            )
            ->add(
                'email',
                EmailType::class,
                [
                    'label' => 'Adresse email',
                    'attr' => [
                        'placeholder' => '@example.com'
                    ]
                ]
            )
            ->add(
                'password',
                RepeatedType::class,
                [
                    'type' => PasswordType::class,
                    'invalid_message' => 'Les mots de passe ne sont pas identiques.',
                    'required' => true,
                    'label' => 'Mot de passe',
                    'first_options' => ['label' => 'Mot de passe'],
                    'second_options' => ['label' => 'Confirmer le mot de passe'],
                    // 'constraints' => [
                    //     new Assert\PasswordStrength([
                    //         'minScore' => PasswordStrength::STRENGTH_WEAK, // Very strong password required
                    //         'message' => 'Votre mot de passe est trop faible.'
                    //     ])
                    // ],
                ]
            )
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'S\'inscrire'
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
