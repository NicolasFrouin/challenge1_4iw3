<?php

namespace App\Entity;

use App\Repository\InvoiceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: InvoiceRepository::class)]
class Invoice
{
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $paid = false;

    #[ORM\Column]
    private ?int $paidAmount = 0;

    private ?float $formPaidAmount = 0;

    #[ORM\ManyToOne(inversedBy: 'invoices')]
    private ?Client $client = null;

    #[ORM\OneToMany(mappedBy: 'invoice', targetEntity: InvoiceLine::class, orphanRemoval: true)]
    private Collection $invoiceLines;

    public function __construct()
    {
        $this->invoiceLines = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isPaid(): ?bool
    {
        return $this->paid;
    }

    public function setPaid(bool $paid): static
    {
        $this->paid = $paid;

        return $this;
    }

    public function getPaidAmount(): ?int
    {
        return $this->paidAmount;
    }

    public function setPaidAmount(int $paidAmount): static
    {
        $this->paidAmount = $paidAmount;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): static
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return Collection<int, InvoiceLine>
     */
    public function getInvoiceLines(): Collection
    {
        return $this->invoiceLines;
    }

    public function addInvoiceLine(InvoiceLine $invoiceLine): static
    {
        if (!$this->invoiceLines->contains($invoiceLine)) {
            $this->invoiceLines->add($invoiceLine);
            $invoiceLine->setInvoice($this);
        }

        return $this;
    }

    public function removeInvoiceLine(InvoiceLine $invoiceLine): static
    {
        if ($this->invoiceLines->removeElement($invoiceLine)) {
            // set the owning side to null (unless already changed)
            if ($invoiceLine->getInvoice() === $this) {
                $invoiceLine->setInvoice(null);
            }
        }

        return $this;
    }

    public function getFormPaidAmount(): ?float
    {
        return $this->formPaidAmount;
    }

    public function setFormPaidAmount(float $formPaidAmount): static
    {
        $this->formPaidAmount = $formPaidAmount;

        return $this;
    }

    public function getTotal(): int
    {
        $total = 0;

        foreach ($this->invoiceLines as $line) {
            $total += $line->getProduct()->getPriceWithTax();
        }

        return $total;
    }
}
