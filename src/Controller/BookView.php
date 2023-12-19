<?php

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var int $id
 */

use Entity\Book;
use Entity\Loan;
use Symfony\Component\HttpFoundation\Response;

$bookRepository = $entityManager->getRepository(Book::class);
$book = $bookRepository->find($id);

$loanRepository = $entityManager->getRepository(Loan::class);
$emprunts = $loanRepository->findBy(['book' => $book]);

return new Response($twig->render('book/show.html.twig', [
    'book' => $book,
    'emprunts' => $emprunts
]));
