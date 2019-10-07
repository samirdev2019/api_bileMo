<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use Hateoas\Configuration\Annotation\Relation;
use Hateoas\Configuration\Annotation\Exclusion;
use Hateoas\Configuration\Annotation as Hateoas;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * 
 * @Serializer\ExclusionPolicy("ALL")

 * @Hateoas\Relation(
 *      "self",
 *      href = @Hateoas\Route(
 *          "app_user_show",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true
 *      ),
 *      exclusion = @Hateoas\Exclusion(
 *           groups = {"users_by_customer"})
 * )
  * @Hateoas\Relation(
 *      "list",
 *      href = @Hateoas\Route(
 *          "app_get_users",
 *          parameters = { "id" = "expr(object.getCustomer().getId())" },
 *          absolute = true),
 *      exclusion = @Hateoas\Exclusion(
 *           groups = {"users_by_customer"})
 * )
 * @Hateoas\Relation(
 *      "modify",
 *      href = @Hateoas\Route(
 *          "app_user_update",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true),
 *      exclusion = @Hateoas\Exclusion(
 *           groups = {"users_by_customer"})
 * )
 * @Hateoas\Relation(
 *      "delete",
 *      href = @Hateoas\Route(
 *          "app_user_delete",
 *          parameters = { "id" = "expr(object.getId())" },
 *          absolute = true),
 *      exclusion = @Hateoas\Exclusion(
 *           groups = {"users_by_customer"})
 * )
 * @Hateoas\Relation(
 *     "Customer",
 *     embedded = @Hateoas\Embedded("expr(object.getCustomer())")
 * )
 */
class User
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     * @Serializer\Groups({"users_by_customer","show_user","update_user"})
     * @Serializer\Expose
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"users_by_customer", "show_user","update_user"})
     * @Assert\NotBlank(groups={"create_user"})
     * @Serializer\Expose
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Serializer\Groups({"users_by_customer", "show_user","update_user"})
     * @Assert\NotBlank(groups={"create_user"})
     * @Serializer\Expose
     */
    private $lastName;

    /**
     * @ORM\Column(type="date", nullable=true)
     * 
     * @Serializer\Type("DateTime<'Y-m-d'>")
     * @Serializer\Groups({"show_user"})
     * @Serializer\Expose
     */
    private $birthDay;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"show_user","create_user","update_user"})
     * @Assert\NotBlank(groups={"create_user"})
     * @Serializer\Expose
     */
    private $address;
    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"users_by_customer", "show_user","update_user"})
     * @Assert\NotBlank(groups={"create_user"})
     * @Serializer\Expose
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"users_by_customer", "show_user","update_user"})
     * @Assert\NotBlank(groups={"create_user"})
     * @Assert\Email(message="The email '{{value}}' is not a valid email",
     * checkMX = true,groups={"create_user"})
     * @Serializer\Expose
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Serializer\Groups({"show_user","update_user"})
     * @Serializer\Expose
     */
    private $mobileNumber;
    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer", inversedBy="users", cascade={"persist"})
     * @ORM\JoinColumn(nullable=false)
     * @ORM\JoinColumn(name="id",                referencedColumnName="id")
     * @Serializer\Groups({"update_user"})
     */
    private $customer;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getBirthDay(): ?\DateTimeInterface
    {
        return $this->birthDay;
    }

    public function setBirthDay(?\DateTimeInterface $birthDay): self
    {
        $this->birthDay = $birthDay;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getCustomer(): ?Customer
    {
        return $this->customer;
    }

    public function setCustomer(?Customer $customer): self
    {
        $this->customer = $customer;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(?string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getMobileNumber(): ?string
    {
        return $this->mobileNumber;
    }

    public function setMobileNumber(?string $mobileNumber): self
    {
        $this->mobileNumber = $mobileNumber;

        return $this;
    }
}
