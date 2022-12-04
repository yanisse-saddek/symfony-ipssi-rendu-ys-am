<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ProductFilterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('filter', ChoiceType::class, [
                'label'=>'Filtrer par',
                'mapped'=>false,
                'choices'=>[
                    'Plus récents'=>'asc',
                    'Plus anciens'=>'desc',
                    'ordre alphabétique'=>'title-asc',
                    'ordre alphabétique inverse'=>'title-desc'
                    // 'ordre alphabétique'=>'title'
                ],
            ] )
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
         ]);
    }
}
