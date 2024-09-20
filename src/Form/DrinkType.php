<?php

namespace App\Form;

use App\Entity\Drink;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class DrinkType extends AbstractType {

    public function buildForm(FormBuilderInterface $builder, array $options): void {
        $builder
            ->add('id', NumberType::class)
            ->add('name', TextType::class, [
                'label' => 'Nom de la boisson',
                'required' => true,
            ])
            ->add('description', TextType::class, [
                'label' => 'Description',
                'required' => true,
            ])
            ->add('icon', FileType::class, [
                'label' => 'Icône',
                'required' => false,
                'mapped' => false
            ])
            ->add('image', FileType::class, [
                'label' => 'Image',
                'required' => false,
                'mapped' => false
            ])
            ->add('drinkIngredients', CollectionType::class, [
                'entry_type' => DrinkIngredientType::class,
                'label' => 'Ingrédients',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => true,
            ])
            ->add('etapes', CollectionType::class, [
                'entry_type' => EtapeType::class,
                'label' => 'Étapes',
                'allow_add' => true,
                'allow_delete' => true,
                'by_reference' => false,
                'required' => false,
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void {
        $resolver->setDefaults([
            'data_class' => Drink::class,
            'csrf_protection' => false,
            'allow_extra_fields' => true,
            'attr' => [
                'enctype' => 'multipart/form-data', // Assure-toi que l'encodage est défini
            ],
        ]);
    }
}
