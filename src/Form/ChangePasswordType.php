<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Formulaire de modification du mot de passe.
 */
class ChangePasswordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        // Champ de l'adresse email (read-only)
        $builder
            ->add('email', EmailType::class, [
                'disabled' => true // champ non mappé
            ]);

        // Champ du prénom (read-only)
        $builder
            ->add('firstname', TextType::class, [
                'disabled' => true, // champ non mappé
                'label' => 'Prénom' // ajoute un label
            ]);

        // Champ du nom (read-only)
        $builder
            ->add('lastname', TextType::class, [
                'disabled' => true, // champ non mappé
                'label' => 'Nom' // ajoute un label
            ]);

        // Champ du mot de passe actuel (non mappé)
        $builder
            ->add('current_password', PasswordType::class, [
                'mapped' => false, // champ non mappé
                'attr' => [
                    'placeholder' => 'Mot de passe actuel'
                ], // ajoute un placeholder
                'label' => 'Mot de passe actuel', // ajoute un label
            ]);

        // Champ du nouveau mot de passe (de type RepeatedType)
        $builder
            ->add('new_password', RepeatedType::class, [  // RepeatedType : type de champ
                'type' => PasswordType::class, // type de champ
                'invalid_message' => 'Les mots de passe ne sont pas identiques.', // message d'erreur
                'required' => true, // champ obligatoire
                'mapped' => false, // champ non mappé (pas besoin de le lié à une entité)
                'first_options' => ['label' => 'Nouveau mot de passe'], // ajoute un label
                'second_options' => ['label' => 'Confirmer le nouveau mot de passe'], // ajoute un label
            ]);

        // Bouton de soumission du formulaire
        $builder
            ->add(
                'submit',
                SubmitType::class,
                [
                    'label' => 'Modifier' // ajoute un label
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class, // Classe de l'entité User
        ]);
    }
}
