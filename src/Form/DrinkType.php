<?php

namespace App\Form;

use App\Entity\Drink;
use App\Entity\Ingredient;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\UX\LiveComponent\Form\Type\LiveCollectionType;

class DrinkType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('name')
            ->add('alcool')
            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'choice_label' => 'id',
                'multiple' => true,
            ])
            ->add('drinkIngredients', LiveCollectionType::class, [
                'entry_type' => DrinkIngredientType::class,
                'entry_options' => ['label' => false],
                'label' => false,
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Drink::class,
        ]);
    }
}
