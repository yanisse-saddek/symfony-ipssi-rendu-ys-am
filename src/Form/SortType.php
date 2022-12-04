<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class SortType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('sort', ChoiceType::class, [
            'label' => 'Filtrer par',
            'mapped' => false,
            'choices' => [
                'Plus récents' => 'desc',
                'Plus anciens' => 'asc',
                'ordre alphabétique'=>'title-asc',
                'ordre alphabétique inverse'=>'title-desc',
                'prix le plus bas au plus haut'=>'price-asc',
                'prix le plus haut au plus bas'=>'price-desc',
                'marque'=>'brand',
                'categorie'=>'category',
            ],
        ])
    ;    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
