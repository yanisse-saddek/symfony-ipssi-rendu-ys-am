<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', null, [
                'label' => 'Titre',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('description', null, [
                'label'=>'Description du produit',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('price', null, [
                'label'=>'Prix',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'name',
                'label' => 'Categorie',
                'attr'=>[
                    'class'=>'form-select'
                ]
            ])
            ->add('image', null, [
                'label'=>'Image',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('brand', null, [
                'label'=>'Marque',
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('quantity', null, [
                'label'=>'Quantité',
                'attr' => [
                    'min' => 1,
                    'max' => 999999,
                    'step' => 1,
                    'class'=>'form-control'
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
