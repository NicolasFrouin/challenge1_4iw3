<?php 
namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $firstname = null;

    #[ORM\Column(length: 255)] // Use VARCHAR for firstname
    private ?string $lastname = null;

    #[ORM\Column(type: 'datetime')] // Use DATETIME for created_at
    private ?\DateTimeInterface $created_at = null;

    #[ORM\Column(type: 'datetime')] // Use DATETIME for modified_at
    private ?\DateTimeInterface $modified_at = null;

    #[ORM\Column(type: 'datetime')] // Use DATETIME for created_by
    private ?\DateTimeInterface $created_by = null;

    #[ORM\Column(type: 'datetime')] // Use DATETIME for modified_by
    private ?\DateTimeInterface $modified_by = null;

    #[ORM\Column(type: 'integer')]
    private ?int $id_company = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): static
    {
        $this->id = $id;

        return $this;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(?string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(?string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): static
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getModifiedAt(): ?\DateTimeInterface
    {
        return $this->modified_at;
    }

    public function setModifiedAt(\DateTimeInterface $modified_at): static
    {
        $this->modified_at = $modified_at;

        return $this;
    }

    public function getCreatedBy(): ?\DateTimeInterface
    {
        return $this->created_by;
    }

    public function setCreatedBy(\DateTimeInterface $created_by): static
    {
        $this->created_by = $created_by;

        return $this;
    }

    public function getModifiedBy(): ?\DateTimeInterface
    {
        return $this->modified_by;
    }

    public function setModifiedBy(\DateTimeInterface $modified_by): static
    {
        $this->modified_by = $modified_by;

        return $this;
    }

    public function getIdCompany(): ?int
    {
        return $this->id_company;
    }

    public function setIdCompany(int $id_company): static
    {
        $this->id_company = $id_company;

        return $this;
    }
}