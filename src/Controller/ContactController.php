<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Repository\ClientRepository;
use App\Repository\ContactRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/contact')]
class ContactController extends AbstractController
{
    // #[Route('/', name: 'app_contact_index', methods: ['GET'])]
    // public function index(ContactRepository $contactRepository): Response
    // {
    //     $contacts = [];

    //     if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN")
    //         $contacts = $contactRepository->findAll();
    //     else
    //         $contacts = $contactRepository->findBy(["idCompany" => $this->getUser()->getIdCompany()->getId()]);

    //     return $this->render('contact/index.html.twig', [
    //         'contacts' => $contacts,
    //     ]);
    // }

    #[Route('/new', name: 'app_contact_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($contact);
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/new.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_show', methods: ['GET'])]
    public function show(Contact $contact): Response
    {
        if ($this->getUser()->getRoles()[0] != "ROLE_ADMIN")
            if ($contact->getIdCompany()->getId() != $this->getUser()->getIdCompany()->getId())
                throw $this->createNotFoundException('The contact does not exist');

        return $this->render('contact/show.html.twig', [
            'contact' => $contact,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_contact_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('contact/edit.html.twig', [
            'contact' => $contact,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_contact_delete', methods: ['POST'])]
    public function delete(Request $request, Contact $contact, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $contact->getId(), $request->request->get('_token'))) {
            $entityManager->remove($contact);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_contact_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/fromClient/{idClient}', name: 'app_contact_from_client', methods: ['GET'])]
    public function fromClient(Request $request, ClientRepository $clientRepository, ContactRepository $contactRepository): Response
    {
        $client = $clientRepository->find($request->get("idClient"));

        $return = [];
        $contacts = [];

        if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN") {
            $contacts = $contactRepository->findBy(["client" => $client->getId()]);
        } else {
            if ($client->getIdCompany()->getId() == $this->getUser()->getIdCompany()->getId()) {
                $contacts = $contactRepository->findBy(["idClient" => $client->getId()]);
            } else {
                throw $this->createNotFoundException('The client does not exist');
            }
        }

        foreach ($contacts as $contact) {
            $return[] = [
                "id" => $contact->getId(),
                "name" => $contact->getName(),
                "email" => $contact->getEmail(),
                "phone" => $contact->getPhone(),
                "client" => $contact->getIdClient()->getId(),
            ];
        }

        $response = new Response();

        $response->setContent(json_encode($return));
        
        return  $response;
    }
}
