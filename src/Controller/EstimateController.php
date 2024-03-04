<?php

namespace App\Controller;

use App\Entity\Estimate;
use App\Entity\Invoice;
use App\Entity\InvoiceLine;
use App\Form\EstimateType;
use App\Repository\EstimateRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/estimate')]
class EstimateController extends AbstractController
{
    #[Route('/', name: 'app_estimate_index', methods: ['GET'])]
    public function index(EstimateRepository $estimateRepository): Response
    {
        $estimates = [];

        if ($this->getUser()->getRoles()[0] == "ROLE_ADMIN")
            $estimates = $estimateRepository->findAll();
        else
            $estimates = $this->getUser()->getIdCompany()->getEstimates();

        return $this->render('estimate/index.html.twig', [
            'estimates' => $estimates,
        ]);
    }

    #[Route('/new', name: 'app_estimate_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $estimate = new Estimate();
        $form = $this->createForm(EstimateType::class, $estimate, ["action" => $this->generateUrl("app_estimate_new")]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($this->getUser()->getRoles()[0] != "ROLE_ADMIN")
                $estimate->setCompany($this->getUser()->getIdCompany());

            $entityManager->persist($estimate);
            $entityManager->flush();

            return $this->redirectToRoute('app_estimate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estimate/new.html.twig', [
            'estimate' => $estimate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estimate_show', methods: ['GET'])]
    public function show(Estimate $estimate): Response
    {
        if ($this->getUser()->getRoles()[0] != "ROLE_ADMIN" && $estimate->getCompany()->getId() != $this->getUser()->getIdCompany()->getId()) {
            throw $this->createNotFoundException();
        }

        return $this->render('estimate/show.html.twig', [
            'estimate' => $estimate,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_estimate_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Estimate $estimate, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getRoles()[0] != "ROLE_ADMIN" && $estimate->getCompany()->getId() != $this->getUser()->getIdCompany()->getId()) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(EstimateType::class, $estimate);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_estimate_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('estimate/edit.html.twig', [
            'estimate' => $estimate,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_estimate_delete', methods: ['POST'])]
    public function delete(Request $request, Estimate $estimate, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getRoles()[0] != "ROLE_ADMIN" && $estimate->getCompany()->getId() != $this->getUser()->getIdCompany()->getId()) {
            throw $this->createNotFoundException();
        }

        if ($this->isCsrfTokenValid('delete' . $estimate->getId(), $request->request->get('_token'))) {
            $entityManager->remove($estimate);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_estimate_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/convert', name: 'app_estimate_convert', methods: ['GET'])]
    public function convertEstimateToInvoice(Estimate $estimate, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getRoles()[0] != "ROLE_ADMIN" && $estimate->getCompany()->getId() != $this->getUser()->getIdCompany()->getId()) {
            throw $this->createNotFoundException();
        }

        $invoice = new Invoice();
        $invoice->setCompany($estimate->getCompany());
        $invoice->setClient($estimate->getClient());
        $invoice->setContact($estimate->getContact());
        $invoice->setStatus(Invoice::STATUS_DRAFT);
        $invoice->setEstimate($estimate);

        foreach ($estimate->getEstimateLines() as $line) {
            $invoiceLine = new InvoiceLine();
            $invoiceLine->setProduct($line->getProduct());
            $invoiceLine->setQuantity($line->getQuantity());
            $invoice->addInvoiceLine($invoiceLine);

            $entityManager->persist($invoiceLine);
        }

        $entityManager->persist($invoice);
        $entityManager->flush();

        return $this->redirectToRoute('app_invoice_show', ["id" => $invoice->getId()], Response::HTTP_SEE_OTHER);
    }
}
