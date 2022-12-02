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
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('description', null, [
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('price', null, [
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('category', EntityType::class, [
                'class' => 'App\Entity\Category',
                'choice_label' => 'name',
                'attr'=>[
                    'class'=>'form-select'
                ]
            ])
            ->add('image', null, [
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('brand', null, [
                'attr'=>[
                    'class'=>'form-control'
                ]
            ])
            ->add('quantity', null, [
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
