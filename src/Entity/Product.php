<?php

namespace App\Entity;

use Symfony\Component\Serializer\Annotation\Groups;
use ApiPlatform\Metadata\ApiResource;
use App\Enum\CategoryEnum;
use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductRepository::class)]
#[ApiResource()]
class Product
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups('product:read')]
    private ?string $title = null;

    #[ORM\Column(length: 255)]
    #[Groups('product:read')]
    private ?string $description = null;

    #[ORM\Column]
    #[Groups('product:read')]
    private ?float $price = null;

    #[ORM\Column(nullable: true)]
    #[Groups('product:read')]
    private ?array $sizes = [];

    #[ORM\Column(type: 'string', enumType: CategoryEnum::class)]
    #[Groups('product:read')]
    private ?CategoryEnum $category = null; // Category as Enum

    #[ORM\Column(length: 255)]
    #[Groups('product:read')]
    private ?string $imageUrl = null;

    #[ORM\Column]
    #[Groups('product:read')]
    private ?int $stockQuantity = null;


    #[ORM\Column(type: 'datetime')]
    #[Groups('product:read')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    #[Groups('product:read')]
    private \DateTimeInterface $updatedAt;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;
        $this->updatedAt = new \DateTime(); // Update timestamp

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;
        $this->updatedAt = new \DateTime(); // Update timestamp

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): static
    {
        $this->price = $price;
        $this->updatedAt = new \DateTime(); // Update timestamp

        return $this;
    }

    public function getSizes(): ?array
    {
        return $this->sizes;
    }

    public function setSizes(?array $sizes): static
    {
        $this->sizes = $sizes;
        $this->updatedAt = new \DateTime(); // Update timestamp

        return $this;
    }

    public function getCategory(): ?CategoryEnum
    {
        return $this->category;
    }

    public function setCategory(CategoryEnum $category): static
    {
        $this->category = $category;
        $this->updatedAt = new \DateTime(); // Update timestamp
        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(string $imageUrl): static
    {
        $this->imageUrl = $imageUrl;
        $this->updatedAt = new \DateTime(); // Update timestamp

        return $this;
    }

    public function getStockQuantity(): ?int
    {
        return $this->stockQuantity;
    }

    public function setStockQuantity(int $stockQuantity): static
    {
        $this->stockQuantity = $stockQuantity;
        $this->updatedAt = new \DateTime(); // Update timestamp

        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }
}
