<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiFilter;
use ApiPlatform\Core\Annotation\ApiResource;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\NumericFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\RangeFilter;
use ApiPlatform\Core\Bridge\Doctrine\Orm\Filter\SearchFilter;
use App\Repository\ProductRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Range;

#[ApiResource(
    collectionOperations: [
        "get" => [
            "method" => "GET",
            "normalization_context" => ["groups" => ["get:collection:product"]],
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
            "denormalization_context" => ["groups" => ["post:collection:product"]],
            "normalization_context" => ["groups" => ["empty"]],
        ]
    ],
    itemOperations: [
        "get" => [
            "method" => "GET",
            "normalization_context" => ["groups" => ["get:item:product"]]
        ]
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ["productName" => "partial"])]
#[ApiFilter(NumericFilter::class, properties: ['code'])]
#[ApiFilter(OrderFilter::class, properties: [
    "id" => "DESC",
    "code" => "DESC",
    "price" => "DESC",
    "productName" => "ASC",
    "type.typeName" => "ASC",
])]
#[ApiFilter(RangeFilter::class, properties: ["product.id"])]
#[ORM\Entity(repositoryClass: ProductRepository::class)]
class Product
{
    /**
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups([
        "get:collection:product",
        "get:item:product",
        "post:collection:product"
    ])]
    private ?int $id = null;

    /**
     * @var int|null
     */
    #[ORM\Column]
    #[NotBlank]
    #[Range(min: 1, max: 10)]
    #[Groups([
        "get:collection:product",
        "get:item:product",
        "post:collection:product"
    ])]
    private ?int $code = null;

    /**
     * @var string|null
     */
    #[NotBlank]
    #[ORM\Column(length: 255)]
    #[Groups([
        "get:collection:product",
        "get:item:product",
        "post:collection:product"
    ])]
    private ?string $productName = null;

    /**
     * @var string|null
     */
    #[NotBlank]
    #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
    #[Range(min: 0)]
    #[Groups([
        "get:collection:product",
        "get:item:product",
        "post:collection:product"
    ])]
    private ?string $price = null;

    /**
     * @var ProductType|null
     */
    #[ORM\ManyToOne(inversedBy: 'products')]
    #[Groups([
        "get:collection:product",
        "get:item:product",
        "post:collection:product"
    ])]
    private ?ProductType $type = null;

    /**
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return int|null
     */
    public function getCode(): ?int
    {
        return $this->code;
    }

    /**
     * @param int $code
     * @return $this
     */
    public function setCode(int $code): static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getProductName(): ?string
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     * @return $this
     */
    public function setProductName(string $productName): static
    {
        $this->productName = $productName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPrice(): ?string
    {
        return $this->price;
    }

    /**
     * @param string $price
     * @return $this
     */
    public function setPrice(string $price): static
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return ProductType|null
     */
    public function getType(): ?ProductType
    {
        return $this->type;
    }

    /**
     * @param ProductType|null $type
     * @return $this
     */
    public function setType(?ProductType $type): static
    {
        $this->type = $type;

        return $this;
    }
}
