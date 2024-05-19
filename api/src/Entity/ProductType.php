<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use App\EntityListener\ExcursionEntityListener;
use App\EntityListener\ProductTypeEntityListener;
use App\Repository\ProductTypeRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;

#[ApiResource(
    collectionOperations: [
        "get" => [
            "method" => "GET",
            "normalization_context" => ["groups" => ["get:collection:productType"]],
            "openapi_context" => [
                "parameters" => [
                    [
                        "name" => "page",
                        "in" => "query",
                        "required" => true,
                        "schema" => ["type" => "integer"],
                    ]
                ]
            ]
        ],
        "post" => [
            "method" => "POST",
            "denormalization_context" => ["groups" => ["post:collection:productType"]],
            "normalization_context" => ["groups" => ["empty"]],
        ]
    ],
    itemOperations: [
        "get" => [
            "method" => "GET",
            "normalization_context" => ["groups" => ["get:item:productType"]]
        ],
        "delete" => [
            "method" => "DELETE",
        ]
    ],
)]
#[ORM\Entity(repositoryClass: ProductTypeRepository::class)]
#[ORM\EntityListeners([ProductTypeEntityListener::class])]
class ProductType
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * @var string|null
     */
    #[NotBlank]
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:collection:productType",
        "get:item:productType",
        "post:collection:productType",
        "get:collection:product",
        "get:item:product",
    ])]
    private ?string $typeName = null;

    /**
     * @var string|null
     */
    #[NotBlank]
    #[ORM\Column(type: Types::TEXT, nullable: true)]
    #[Groups([
        "get:collection:productType",
        "get:item:productType",
        "post:collection:productType",
        "get:collection:product",
        "get:item:product",
    ])]
    private ?string $description = null;

    /**
     * @var Collection
     */
    #[ORM\OneToMany(mappedBy: 'type', targetEntity: Product::class)]
    #[Groups([
        "get:collection:productType",
        "get:item:productType",
    ])]
    private Collection $products;

    /**
     *
     */
    public function __construct()
    {
        $this->products = new ArrayCollection();
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getTypeName(): ?string
    {
        return $this->typeName;
    }

    /**
     * @param string $typeName
     * @return $this
     */
    public function setTypeName(string $typeName): static
    {
        $this->typeName = $typeName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * @param string|null $description
     * @return $this
     */
    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProducts(): Collection
    {
        return $this->products;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function addProduct(Product $product): static
    {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
            $product->setType($this);
        }

        return $this;
    }

    /**
     * @param Product $product
     * @return $this
     */
    public function removeProduct(Product $product): static
    {
        if ($this->products->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getType() === $this) {
                $product->setType(null);
            }
        }

        return $this;
    }

}
