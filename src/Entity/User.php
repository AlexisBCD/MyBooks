<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Repository\UserRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: 'users')]

class User
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private $id;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private $username;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private $password;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private $email;

    public function getID(): ?string
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }
}
