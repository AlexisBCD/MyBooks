<?php

namespace Entity;

use Doctrine\ORM\Mapping as ORM;
use Repository\LoanRepository;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: LoanRepository::class)]
#[ORM\Table(name: 'loan')]
class Loan
{
    #[ORM\Id]
    #[ORM\Column(type: 'integer')]
    #[ORM\GeneratedValue]
    private int|null $id = null;

    #[ORM\ManyToOne(targetEntity: Book::class)]
    #[ORM\JoinColumn(name: 'book_id', referencedColumnName: 'id')]
    #[Assert\NotBlank]
    private Book $book;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    private string $borrowerName;

    #[ORM\Column(type: 'string')]
    #[Assert\NotBlank]
    #[Assert\Email]
    private string $borrowerEmail;

    #[ORM\Column(type: 'datetime')]
    #[Assert\NotBlank]
    private \DateTimeInterface $loanDate;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): Loan
    {
        $this->id = $id;
        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(Book $book): Loan
    {
        $this->book = $book;
        return $this;
    }

    public function getBorrowerName(): ?string
    {
        return $this->borrowerName;
    }

    public function setBorrowerName(string $borrowerName): Loan
    {
        $this->borrowerName = $borrowerName;
        return $this;
    }

    public function getBorrowerEmail(): ?string
    {
        return $this->borrowerEmail;
    }

    public function setBorrowerEmail(string $borrowerEmail): Loan
    {
        $this->borrowerEmail = $borrowerEmail;
        return $this;
    }

    public function getLoanDate(): ?\DateTimeInterface
    {
        return $this->loanDate;
    }

    public function setLoanDate(\DateTimeInterface $loanDate): Loan
    {
        $this->loanDate = $loanDate;
        return $this;
    }
}
