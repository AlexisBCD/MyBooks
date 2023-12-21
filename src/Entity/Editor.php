<?php

namespace Entity;

use Repository\EditorRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;


#[ORM\Entity(repositoryClass: EditorRepository::class)]
#[ORM\Table(name: 'editor')]
class Editor
{

    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private string $adresse;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private string $email;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private string $nom;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private string $tel;

    /*
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Editor
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return string
     */
    public function getAdresse(): string
    {
        return $this->adresse;
    }

    /**
     * @param string $adresse
     * @return Editor
     */
    public function setAdresse(string $adresse): Editor
    {
        $this->adresse = $adresse;
        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     * @return Editor
     */
    public function setEmail(string $email): Editor
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return string
     */
    public function getNom(): string
    {
        return $this->nom;
    }

    /**
     * @param string $nom
     * @return Editor
     */
    public function setNom(string $nom): Editor
    {
        $this->nom = $nom;
        return $this;
    }

    /**
     * @return string
     */
    public function getTel(): string
    {
        return $this->tel;
    }

    /**
     * @param string $tel
     * @return Editor
     */
    public function setTel(string $tel): Editor
    {
        $this->tel = $tel;
        return $this;
    }
}
