<?php

namespace App\Form;

use App\Entity\Company;
use App\Entity\User;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Choice;

class UserType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            // ->add('roles', ChoiceType::class, [
            //     'choices' => [
            //         'Utilisateur' => 'ROLE_USER',
            //         'Administrateur' => 'ROLE_ADMIN',
            //     ],
            //     'multiple' => true,
            //     'expanded' => true,
            //     'label' => 'Rôles',
            // ])
            ->add('password')
            ->add('isVerified');

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
            'data_class' => User::class,
        ]);
    }
}
