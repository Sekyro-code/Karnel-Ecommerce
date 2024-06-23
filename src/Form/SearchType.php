<?php

namespace App\Form;

use App\class\Search;
use App\Entity\Category;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use symfony\component\form\FormBuilderInterface;

class SearchType extends AbstractType
{

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('string', TextType::class, [
                'label' => false, // Supprime le label
                'required' => false, // Obligation de remplir le champ
                'attr' => ['placeholder' => 'Rechercher', 'class' => 'form-control-sm custom-input'] // Attribut de l'input
            ])
            ->add('categories', EntityType::class, [
                'label' => false, // Supprime le label
                'required' => false, // Obligation de selectionner au moins une categorie
                'class' => Category::class, // Classe de l'entité Category
                'multiple' => true, // Permet de selectionner plusieurs categories
                'expanded' => true, // Permet de selectionner plusieurs categories
                'choice_attr' => function($category, $key, $value) {
                    return ['class' => 'custom-checkbox'];
                },
            ])
            ->add('submit', SubmitType::class, [
                'label' => 'Filtrer', // Label du bouton
                'attr' => [
                    'class' => 'btn-block btn-info custom-btn' // Attribut de l'input
                ]

            ]);  // Bouton de recherche )
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Search::class, // Classe de "Search" qui contient les paramètres de recherche
            'method' => 'GET', // Donnée envoyée par url
            'csrf_protection' => false // Formule de recherche, supprime le token pour échanger l'url
        ]);
    }
    // Retourne le nom de la classe
    public function getBlockPrefix()
    {
        return ''; // Evite de retourner le nom de la classe dans un tableau pour avoir une url propre
    }
}
