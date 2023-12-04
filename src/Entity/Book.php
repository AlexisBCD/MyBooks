<?php

namespace Entity;


use Doctrine\ORM\Mapping as ORM;
use Repository\BookRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;


#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ORM\Table(name: 'livres')]
class Book
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private String $titre;
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private String $auteur;
    #[ORM\Column(type: 'date')]
    #[Assert\NotBlank]
    private Date $anneePublication;
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private String $editeur;
    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private String $ISBN;

    /*
 * @return int|null
 */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Book
    {
        $this->id = $id;
        return $this;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): Book
    {
        $this->titre = $titre;
        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(string $auteur): Book
    {
        $this->auteur = $auteur;
        return $this;
    }

    public function getAnneePublication(): ?Date
    {
        return $this->anneePublication;
    }

    public function setAnneePublication(string $anneePublication): Book
    {
        $this->anneePublication = $anneePublication;
        return $this;
    }

    public function getEditeur(): ?string
    {
        return $this->editeur;
    }

    public function setEditeur(string $editeur): Book
    {
        $this->editeur = $editeur;
        return $this;
    }

    public function getISBN(): ?string
    {
        return $this->ISBN;
    }

    public function setISBN(string $ISBN): Book
    {
        $this->ISBN = $ISBN;
        return $this;
    }
}
