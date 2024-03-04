<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\Product;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $defaultClass = "inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 dark:text-white";

        $builder
            ->add(
                'ref',
                TextType::class,
                [
                    'label' => 'Référence',
                    'attr' => ['placeholder' => 'Référence du produit'],
                    'label_attr' => ['class' => 'inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 dark:inline-flex items-center justify-center px-2 ms-3 text-sm font-medium text-gray-800 dark:text-white'],
                ]
            )
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Nom',
                    'attr' => ['placeholder' => 'Nom du produit'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            )
            ->add(
                'description',
                TextType::class,
                [
                    'label' => 'Description',
                    'attr' => ['placeholder' => 'Description du produit'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            )
            ->add(
                'taxRate',
                NumberType::class,
                [
                    'label' => 'Taux de TVA',
                    'attr' => ['placeholder' => 'Taux de TVA du produit'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            )
            ->add(
                'priceNoTax',
                NumberType::class,
                [
                    'label' => 'Prix HT',
                    'attr' => ['placeholder' => 'Prix HT du produit'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            )
            ->add(
                'priceWithTax',
                NumberType::class,
                [
                    'label' => 'Prix TTC',
                    'attr' => ['placeholder' => 'Prix TTC du produit'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            )
            ->add(
                'weight',
                NumberType::class,
                [
                    'label' => 'Poids',
                    'attr' => ['placeholder' => 'Poids du produit'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            )
            ->add(
                'height',
                NumberType::class,
                [
                    'label' => 'Hauteur',
                    'attr' => ['placeholder' => 'Hauteur du produit'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            )
            ->add(
                'width',
                NumberType::class,
                [
                    'label' => 'Largeur',
                    'attr' => ['placeholder' => 'Largeur du produit'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            )
            ->add(
                'depth',
                NumberType::class,
                [
                    'label' => 'Profondeur',
                    'attr' => ['placeholder' => 'Profondeur du produit'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            )
            ->add(
                'stock',
                NumberType::class,
                [
                    'label' => 'Stock',
                    'attr' => ['placeholder' => 'Stock du produit'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            )
            ->add(
                'active',
                CheckboxType::class,
                [
                    'label' => 'Actif',
                    'attr' => ['placeholder' => 'Actif'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            );

        if ($this->security->getUser()->getRoles()[0] === 'ROLE_ADMIN') {
            $builder->add(
                'idCompany',
                EntityType::class,
                [
                    'class' => Company::class,
                    'choice_label' => 'name',
                    'label' => 'Entreprise',
                    'attr' => ['placeholder' => 'Entreprise'],
                    'label_attr' => ['class' => $defaultClass]
                ]
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
