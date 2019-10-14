<?php

namespace App\Entity;

use Nelmio\ApiDocBundle\Annotation\Model;
use Swagger\Annotations as SWG;
use Doctrine\ORM\Mapping as ORM;
use Swagger\Annotations\Property;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 *
 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "app_product_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *           groups = {"list_product"})
 * )
 * @Hateoas\Relation(
 *      "list",
 *      href = @Hateoas\Route(
 *          "app_product_list",
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *           groups = {"show_product"})
 * )
 */
class Product
{

 
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups("list_product")
     *
     * @var int
     * @SWG\Property(description="The unique identifier of the product.")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list_product","show_product"})
     *
     * @var string
     * @SWG\Property(description="The mark of the product.")
     */
    private $mark;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"list_product","show_product"})
     *
     * @var string
     * @SWG\Property(description="The reference of the product.")
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups("show_product")
     *
     * @var string
     * @SWG\Property(description="The storage capacity of the product.")
     */
    private $storageCapacityROM;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups("show_product")
     *
     * @var string
     * @SWG\Property(description="The product read access memory.")
     */
    private $memory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups("show_product")
     *
     * @var string|null
     * @SWG\Property(description="The product extesible max memory card.")
     */
    private $maxMemoryCard;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups("show_product")
     *
     * @var string
     * @SWG\Property(description="The product screan size ")
     */
    private $screenSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups("show_product")
     *
     * @var string|null
     * @SWG\Property(description="The product principal camera resolution: e.g 12Mpx ")
     */
    private $principalCameraResolution;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups("show_product")
     *
     * @var string|null
     * @SWG\Property(description="The product second camera resolution: e.g 8Mpx ")
     */
    private $secondCameraResolution;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     * @Serializer\Groups("show_product")
     *
     * @var string|null
     * @SWG\Property(description="true if product have colors")
     */
    private $color;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, nullable=true)
     * @Serializer\Groups("show_product")
     *
     * @var string|null
     * @SWG\Property(description="the product price ")
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups("show_product")
     *
     * @var string
     * @SWG\Property(description="the operating system e.g :ANDROID")
     */
    private $operatingSystem;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups("show_product")
     *
     * @var string|null
     * @SWG\Property(description="the processor of product e.g :1.53x2 Ghz")
     */
    private $processor;

    /**
     * @Serializer\Groups("show_product")
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @var \DateTimeInterface|null
     * @SWG\Property(type="string", format="date-time", description="the product publication date")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Serializer\Groups("show_product")
     *
     * @var string|null
     * @SWG\Property(description="the product description")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups("show_product")
     *
     * @var string|null
     * @SWG\Property(description="the URL image of product")
     */
    private $imageUrl;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMark(): ?string
    {
        return $this->mark;
    }

    public function setMark(string $mark): self
    {
        $this->mark = $mark;

        return $this;
    }

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

        return $this;
    }

    public function getStorageCapacityROM(): ?string
    {
        return $this->storageCapacityROM;
    }

    public function setStorageCapacityROM(string $storageCapacityROM): self
    {
        $this->storageCapacityROM = $storageCapacityROM;

        return $this;
    }

    public function getMemory(): ?string
    {
        return $this->memory;
    }

    public function setMemory(string $memory): self
    {
        $this->memory = $memory;

        return $this;
    }

    public function getMaxMemoryCard(): ?string
    {
        return $this->maxMemoryCard;
    }

    public function setMaxMemoryCard(?string $maxMemoryCard): self
    {
        $this->maxMemoryCard = $maxMemoryCard;

        return $this;
    }

    public function getScreenSize(): ?string
    {
        return $this->screenSize;
    }

    public function setScreenSize(string $screenSize): self
    {
        $this->screenSize = $screenSize;

        return $this;
    }

    public function getPrincipalCameraResolution(): ?string
    {
        return $this->principalCameraResolution;
    }

    public function setPrincipalCameraResolution(?string $principalCameraResolution): self
    {
        $this->principalCameraResolution = $principalCameraResolution;

        return $this;
    }

    public function getSecondCameraResolution(): ?string
    {
        return $this->secondCameraResolution;
    }

    public function setSecondCameraResolution(?string $secondCameraResolution): self
    {
        $this->secondCameraResolution = $secondCameraResolution;

        return $this;
    }

    public function getColor(): ?bool
    {
        return $this->color;
    }

    public function setColor(?bool $color): self
    {
        $this->color = $color;

        return $this;
    }

    public function getPrice(): ?string
    {
        return $this->price;
    }

    public function setPrice(?string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getOperatingSystem(): ?string
    {
        return $this->operatingSystem;
    }

    public function setOperatingSystem(string $operatingSystem): self
    {
        $this->operatingSystem = $operatingSystem;

        return $this;
    }

    public function getProcessor(): ?string
    {
        return $this->processor;
    }

    public function setProcessor(?string $processor): self
    {
        $this->processor = $processor;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl(?string $imageUrl): self
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }
}
