<?php

use Entity\Book;
/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var int $id
 */


$bookRepository = $entityManager->getRepository(Book::class);

$book = $bookRepository->find($id);
$entityManager->remove($book);
$entityManager->flush();

return new \Symfony\Component\HttpFoundation\RedirectResponse('/book');
?>