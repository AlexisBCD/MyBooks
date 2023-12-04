<?php

namespace Acgroup\MyBooks\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\LivreRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Date;


#[ORM\Entity(repositoryClass: LivreRepository::class)]
#[ORM\Table(name: 'livres')]
class Livre
{
   #[ORM\Id]
   #[ORM\Column(type:'integer')]
   #[ORM\GeneratedValue]
    private int|null $id = null;
   #[ORM\Column(type : 'string')]
   #[Assert\NotBlank]
    private String $titre;
    #[ORM\Column(type : 'string')]
    #[Assert\NotBlank]
    private String $auteur;
    #[ORM\Column(type : 'date')]
    #[Assert\NotBlank]
    private Date $anneePublication;
    #[ORM\Column(type : 'string')]
    #[Assert\NotBlank]
    private String $editeur;
    #[ORM\Column(type : 'string')]
    #[Assert\NotBlank]
    private String $ISBN;

    public function __construct(int $id, String $titre, String $auteur, Date $anneePublication, String $editeur, String $ISBN ){
        $this->id = $id;
        $this->titre = $titre;
        $this->auteur = $auteur;
        $this->anneePublication = $anneePublication;
        $this->editeur = $editeur;
        $this->ISBN = $ISBN;
    }

 /*
 * @return int|null
 */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getTItre(): ?string{
        return $this->titre;
    }

    public function setTitre(String $titre) : void{
        $this->titre = $titre;
    }

    public function getAuteur(): ?string{
        return $this->auteur;
    }

    public function setAuteur(String $auteur) : void{
        $this->auteur = $auteur;
    }

    public function getAnneePublication(): ?Date{
        return $this->anneePublication;
    }

    public function setAnneePublication(Date $anneePublication) : void{
        $this->anneePublication = $anneePublication;
    }

    public function getEditeur(): ?string{
        return $this->editeur;
    }

    public function setEditeur(String $editeur):void{
        $this->editeur = $editeur;
    }

    public function getISBN():?string{
        return $this->ISBN;
    }

    public function setISBN(string $isbn):void{
        $this->ISBN = $isbn;
    }
}