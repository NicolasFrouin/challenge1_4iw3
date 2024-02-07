<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "La référence est obligatoire")]
    private ?string $ref = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    #[Assert\Range(min: 0, max: 45, notInRangeMessage: "Le taux de TVA doit être compris entre 0 et 45%")]
    private ?float $taxRate = 0; // in percent (0 to 100)

    #[ORM\Column]
    #[Assert\LessThanOrEqual(propertyPath: "priceWithTax", message: "Le prix HT doit être inférieur ou égal au prix TTC")]
    private ?int $priceNoTax = 0; // in cents

    #[ORM\Column]
    #[Assert\GreaterThanOrEqual(propertyPath: "priceNoTax", message: "Le prix TTC doit être supérieur ou égal au prix HT")]
    private ?int $priceWithTax = 0; // in cents

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?float $weight = null; // in grams

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?float $height = null; // in cm

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?float $width = null; // in cm

    #[ORM\Column(nullable: true)]
    #[Assert\PositiveOrZero]
    private ?float $depth = null; // in cm

    #[ORM\Column]
    private ?int $stock = 0;

    #[ORM\Column]
    private ?bool $active = false;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $modifiedAt = null;

    #[ORM\ManyToOne(inversedBy: 'createdProducts')]
    private ?User $createdBy = null;

    #[ORM\ManyToOne(inversedBy: 'modifiedProducts')]
    private ?User $modifiedBy = null;

    #[ORM\ManyToOne(inversedBy: 'products')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Company $idCompany = null;

    public function __construct()
    {
        $this->setCreatedAt(new \DateTimeImmutable());
    }

    #[ORM\PreUpdate]
    #[ORM\PrePersist]
    public function updateModifiedAt(): void
    {
        $this->setModifiedAt(new \DateTimeImmutable());
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getRef(): ?string
    {
        return $this->ref;
    }

    public function setRef(string $ref): static
    {
        $this->ref = $ref;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getTaxRate(): ?float
    {
        return $this->taxRate;
    }

    public function setTaxRate(float $taxRate): static
    {
        $this->taxRate = $taxRate;

        return $this;
    }

    public function getPriceNoTax(): ?int
    {
        return $this->priceNoTax;
    }

    public function setPriceNoTax(int $priceNoTax): static
    {
        $this->priceNoTax = $priceNoTax;

        return $this;
    }

    public function getPriceWithTax(): ?int
    {
        return $this->priceWithTax;
    }

    public function setPriceWithTax(int $priceWithTax): static
    {
        $this->priceWithTax = $priceWithTax;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): static
    {
        $this->weight = $weight;

        return $this;
    }

    public function getHeight(): ?float
    {
        return $this->height;
    }

    public function setHeight(?float $height): static
    {
        $this->height = $height;

        return $this;
    }

    public function getWidth(): ?float
    {
        return $this->width;
    }

    public function setWidth(?float $width): static
    {
        $this->width = $width;

        return $this;
    }

    public function getDepth(): ?float
    {
        return $this->depth;
    }

    public function setDepth(?float $depth): static
    {
        $this->depth = $depth;

        return $this;
    }

    public function getStock(): ?int
    {
        return $this->stock;
    }

    public function setStock(int $stock): static
    {
        $this->stock = $stock;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): static
    {
        $this->active = $active;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeImmutable
    {
        return $this->modifiedAt;
    }

    public function setModifiedAt(\DateTimeImmutable $modifiedAt): static
    {
        $this->modifiedAt = $modifiedAt;

        return $this;
    }

    public function getCreatedBy(): ?User
    {
        return $this->createdBy;
    }

    public function setCreatedBy(?User $createdBy): static
    {
        $this->createdBy = $createdBy;

        return $this;
    }

    public function getModifiedBy(): ?User
    {
        return $this->modifiedBy;
    }

    public function setModifiedBy(?User $modifiedBy): static
    {
        $this->modifiedBy = $modifiedBy;

        return $this;
    }

    public function getIdCompany(): ?Company
    {
        return $this->idCompany;
    }

    public function setIdCompany(?Company $idCompany): static
    {
        $this->idCompany = $idCompany;

        return $this;
    }
}
