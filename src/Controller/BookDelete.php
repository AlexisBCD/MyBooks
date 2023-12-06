<?php

use Entity\Book;
use Security\Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var int $id
 */

Authenticator::init();

if (Authenticator::is_authenticated()) {
    $bookRepository = $entityManager->getRepository(Book::class);
    $book = $bookRepository->find($id);
    $entityManager->remove($book);
    $entityManager->flush();

    return new \Symfony\Component\HttpFoundation\RedirectResponse('/book');
} else {
    return new RedirectResponse(Authenticator::urlNotLogged());
}
