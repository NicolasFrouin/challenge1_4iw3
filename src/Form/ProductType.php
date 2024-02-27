<?php

namespace App\Form;

use App\Entity\Product;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('ref', TextType::class, ['label' => 'Référence', 'attr' => ['placeholder' => 'Référence du produit'], 'label_attr' => ['class' => 'text-red'],])
            ->add('name', TextType::class, ['label' => 'Nom', 'attr' => ['placeholder' => 'Nom du produit'], 'label_attr' => ['class' => 'text-white']])
            ->add('description', TextType::class, ['label' => 'Description', 'attr' => ['placeholder' => 'Description du produit'], 'label_attr' => ['class' => 'text-white']])
            ->add('taxRate', NumberType::class, ['label' => 'Taux de TVA', 'attr' => ['placeholder' => 'Taux de TVA du produit'], 'label_attr' => ['class' => 'text-white']])
            ->add('priceNoTax', NumberType::class, ['label' => 'Prix HT', 'attr' => ['placeholder' => 'Prix HT du produit'], 'label_attr' => ['class' => 'text-white']])
            ->add('priceWithTax', NumberType::class, ['label' => 'Prix TTC', 'attr' => ['placeholder' => 'Prix TTC du produit'], 'label_attr' => ['class' => 'text-white']])
            ->add('weight', NumberType::class, ['label' => 'Poids', 'attr' => ['placeholder' => 'Poids du produit'], 'label_attr' => ['class' => 'text-white']])
            ->add('height', NumberType::class, ['label' => 'Hauteur', 'attr' => ['placeholder' => 'Hauteur du produit'], 'label_attr' => ['class' => 'text-white']])
            ->add('width', NumberType::class, ['label' => 'Largeur', 'attr' => ['placeholder' => 'Largeur du produit'], 'label_attr' => ['class' => 'text-white']])
            ->add('depth', NumberType::class, ['label' => 'Profondeur', 'attr' => ['placeholder' => 'Profondeur du produit'], 'label_attr' => ['class' => 'text-white']])
            ->add('stock', NumberType::class, ['label' => 'Stock', 'attr' => ['placeholder' => 'Stock du produit'], 'label_attr' => ['class' => 'text-white']])
            ->add('active', null, ['label' => 'Actif', 'attr' => ['placeholder' => 'Actif'], 'label_attr' => ['class' => 'text-white']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
