<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 */
class Product
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $mark;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $reference;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $storageCapacityROM;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $memory;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $maxMemoryCard;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $screenSize;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $principalCameraResolution;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $secondCameraResolution;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $color;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2, nullable=true)
     */
    private $price;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $operatingSystem;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $processor;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $createdAt;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
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
