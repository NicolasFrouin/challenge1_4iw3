<?php

namespace App\Controller;

use App\Entity\Invoice;
use App\Form\InvoiceType;
use App\Repository\InvoiceRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/invoice')]
class InvoiceController extends AbstractController
{
    #[Route('/', name: 'app_invoice_index', methods: ['GET'])]
    public function index(InvoiceRepository $invoiceRepository): Response
    {
        $invoices = [];

        if ($this->getUser()->getRoles()[0] === 'ROLE_ADMIN') {
            $invoices = $invoiceRepository->findAll();
        } else if ($this->getUser()->getIdCompany()) {
            $invoices = $this->getUser()->getIdCompany()->getInvoices();
        }

        return $this->render('invoice/index.html.twig', [
            'invoices' => $invoices,
        ]);
    }

    #[Route('/new', name: 'app_invoice_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $invoice = new Invoice();
        $form = $this->createForm(InvoiceType::class, $invoice, ["action" => $this->generateUrl("app_invoice_new")]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if (!is_numeric($invoice->getFormPaidAmount()) || $invoice->getFormPaidAmount() < 0) {
                $invoice->setFormPaidAmount(0);
            }
            $invoice->setPaidAmount($invoice->getFormPaidAmount() * 100); // transform to cents
            if ($invoice->isPaid()) {
                $invoice->setPaidAmount($invoice->getTotal());
            }
            if ($this->getUser()->getRoles()[0] !== 'ROLE_ADMIN') {
                $invoice->setCompany($this->getUser()->getIdCompany());
            }

            $entityManager->persist($invoice);
            $entityManager->flush();

            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invoice/new.html.twig', [
            // 'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoice_show', methods: ['GET'])]
    public function show(Invoice $invoice): Response
    {
        if ($this->getUser()->getRoles()[0] !== 'ROLE_ADMIN' && $invoice->getCompany()->getId() !== $this->getUser()->getIdCompany()->getId()) {
            throw $this->createNotFoundException();
        }

        return $this->render('invoice/show.html.twig', [
            'invoice' => $invoice,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_invoice_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Invoice $invoice, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getRoles()[0] !== 'ROLE_ADMIN' && $invoice->getCompany()->getId() !== $this->getUser()->getIdCompany()->getId()) {
            throw $this->createNotFoundException();
        }

        $form = $this->createForm(InvoiceType::class, $invoice);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('invoice/edit.html.twig', [
            'invoice' => $invoice,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_invoice_delete', methods: ['POST'])]
    public function delete(Request $request, Invoice $invoice, EntityManagerInterface $entityManager): Response
    {
        if ($this->getUser()->getRoles()[0] !== 'ROLE_ADMIN' && $invoice->getCompany()->getId() !== $this->getUser()->getIdCompany()->getId()) {
            throw $this->createNotFoundException();
        }
        
        if ($this->isCsrfTokenValid('delete' . $invoice->getId(), $request->request->get('_token'))) {
            $entityManager->remove($invoice);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_invoice_index', [], Response::HTTP_SEE_OTHER);
    }
}
