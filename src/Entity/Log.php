<?php

namespace Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Repository\LogRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LogRepository::class)]
#[ORM\Table(name: 'logs')]

class Log
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private $message;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    private $createdAt;

    public function __construct()
    {
        $this->createdAt = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getCreationDate(): ?DateTime
    {
        return $this->createdAt;
    }
}
