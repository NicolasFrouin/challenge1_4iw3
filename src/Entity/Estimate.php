<?php

namespace App\Entity;

use App\Repository\EstimateRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Blameable\Traits\BlameableEntity;
use Gedmo\Timestampable\Traits\TimestampableEntity;

#[ORM\Entity(repositoryClass: EstimateRepository::class)]
class Estimate
{
    use BlameableEntity;
    use TimestampableEntity;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $signed = null;

    #[ORM\ManyToOne(inversedBy: 'estimates')]
    private ?Company $company = null;

    #[ORM\ManyToOne(inversedBy: 'estimates')]
    private ?Client $client = null;

    #[ORM\ManyToOne(inversedBy: 'estimates')]
    private ?Contact $contact = null;

    #[ORM\OneToMany(mappedBy: 'estimate', targetEntity: EstimateLine::class)]
    private Collection $estimateLines;

    #[ORM\Column]
    private ?int $status = 0;

    #[ORM\OneToMany(mappedBy: 'estimate', targetEntity: Invoice::class)]
    private Collection $invoices;

    public const STATUS_DRAFT = 0;
    public const STATUS_VALIDATED = 1;
    public const STATUS_ABORTED = 9;

    public function __construct()
    {
        $this->estimateLines = new ArrayCollection();
        $this->invoices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isSigned(): ?bool
    {
        return $this->signed;
    }

    public function setSigned(bool $signed): static
    {
        $this->signed = $signed;

        return $this;
    }

    public function getCompany(): ?Company
    {
        return $this->company;
    }

    public function setCompany(?Company $company): static
    {
        $this->company = $company;

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

    public function getContact(): ?Contact
    {
        return $this->contact;
    }

    public function setContact(?Contact $contact): static
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * @return Collection<int, EstimateLine>
     */
    public function getEstimateLines(): Collection
    {
        return $this->estimateLines;
    }

    public function addEstimateLine(EstimateLine $estimateLine): static
    {
        if (!$this->estimateLines->contains($estimateLine)) {
            $this->estimateLines->add($estimateLine);
            $estimateLine->setEstimate($this);
        }

        return $this;
    }

    public function removeEstimateLine(EstimateLine $estimateLine): static
    {
        if ($this->estimateLines->removeElement($estimateLine)) {
            // set the owning side to null (unless already changed)
            if ($estimateLine->getEstimate() === $this) {
                $estimateLine->setEstimate(null);
            }
        }

        return $this;
    }

    public function getTotal(): int
    {
        $total = 0;

        foreach ($this->estimateLines as $line) {
            $total += $line->getProduct()->getPriceWithTax();
        }

        return $total;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): static
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Invoice>
     */
    public function getInvoices(): Collection
    {
        return $this->invoices;
    }

    public function addInvoice(Invoice $invoice): static
    {
        if (!$this->invoices->contains($invoice)) {
            $this->invoices->add($invoice);
            $invoice->setEstimate($this);
        }

        return $this;
    }

    public function removeInvoice(Invoice $invoice): static
    {
        if ($this->invoices->removeElement($invoice)) {
            // set the owning side to null (unless already changed)
            if ($invoice->getEstimate() === $this) {
                $invoice->setEstimate(null);
            }
        }

        return $this;
    }
}
