<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Company;
use App\Entity\Contact;
use App\Entity\Estimate;
use App\Repository\ClientRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EstimateType extends AbstractType
{
    public function __construct(private Security $security)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('signed', CheckboxType::class, [
                'label' => 'Signé',
                'required' => false,
            ])
            ->add("client", EntityType::class, [
                "label" => "Client",
                "class" => Client::class,
                "query_builder" => function (ClientRepository $clientRepository) {
                    if ($this->security->isGranted("ROLE_ADMIN")) {
                        return $clientRepository->createQueryBuilder("c");
                    }
                    return $clientRepository->createQueryBuilder("c")
                        ->where("c.idCompany = :idCompany")
                        ->setParameter("idCompany", $this->security->getUser()->getIdCompany()->getId(), \PDO::PARAM_INT);
                },
                "choice_label" => fn (Client $client) => implode(" ", [$client->getFirstName(), $client->getLastName()]),
            ]);

        $formModifier = function (FormInterface $form, Client $client = null) {
            $contacts = null === $client ? [] : $client->getContacts();

            $form->add('contact', EntityType::class, [
                'label' => 'Contact',
                'class' => Contact::class,
                'choices' => $contacts,
            ]);
        };

        $builder->addEventListener(
            FormEvents::PRE_SET_DATA,
            function (FormEvent $event) use ($formModifier) {
                $data = $event->getData();
                $formModifier($event->getForm(), $data->getClient());
            }
        );

        $builder->get('client')->addEventListener(
            FormEvents::POST_SUBMIT,
            function (FormEvent $event) use ($formModifier) {
                $client = $event->getForm()->getData();
                $formModifier($event->getForm()->getParent(), $client);
            }
        );

        $builder->setAction($options["action"]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Estimate::class,
        ]);
    }
}
