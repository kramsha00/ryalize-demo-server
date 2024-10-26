<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    public ?int $id = null;

    /**
     * @Assert\NotBlank(message="First name is required.")
     * @Assert\Length(
     *     max=255,
     *     maxMessage="First name cannot exceed {{ limit }} characters."
     * )
     */
    #[ORM\Column(length: 255)]
    public ?string $firstName = null;

    /**
     * @Assert\NotBlank(message="Last name is required.")
     * @Assert\Length(
     *     max=255,
     *     maxMessage="Last name cannot exceed {{ limit }} characters."
     * )
     */
    #[ORM\Column(length: 255)]
    public ?string $lastName = null;

    /**
     * @Assert\NotBlank(message="Email is required.")
     * @Assert\Email(
     *     message="The email '{{ value }}' is not a valid email address."
     * )
     */
    #[ORM\Column(length: 255, unique: true)]
    public ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $password = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }
}
