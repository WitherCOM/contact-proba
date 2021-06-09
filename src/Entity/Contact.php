<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ContactRepository::class)
 */
class Contact
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(
        min: 0,
        max: 50,)]
    private $name;

    /**
     * @ORM\Column(type="string", length=80)
     */
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Email]
    #[Assert\Length(
        min: 0,
        max: 80,)]
    private $email;

    /**
     * @ORM\Column(type="string", length=500)
     */
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(
        min: 0,
        max: 500,)]
    private $text;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): self
    {
        $this->text = $text;

        return $this;
    }
}
