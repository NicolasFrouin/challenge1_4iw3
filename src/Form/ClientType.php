<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Company;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('firstname')
            ->add('lastname')
            ->add('email')
            ->add('address')
            ->add('phone')
            ->add('createdBy')
            ->add('updatedBy')
            ->add('createdAt')
            ->add('updatedAt');

        if ($this->security->getUser()->getRoles()[0] === 'ROLE_ADMIN') {
            $builder->add(
                'idCompany',
                EntityType::class,
                [
                    'class' => Company::class,
                    'choice_label' => 'name',
                    'label' => 'Entreprise',
                    'attr' => ['placeholder' => 'Entreprise'],
                ]
            );
        }
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
