<?php

use Entity\Book;
use Monolog\Logger;
use Security\Authenticator;
use Logger\DatabaseHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var int $id
 */

if (Authenticator::is_authenticated()) {
    $bookRepository = $entityManager->getRepository(Book::class);
    $book = $bookRepository->find($id);
    $entityManager->remove($book);
    $entityManager->flush();

    $customHandler = new DatabaseHandler($entityManager);
    $logger = new Logger('app');
    $logger->pushHandler($customHandler);
    $logger->info('Livre supprimé par ' . Authenticator::getUser() . ' : ' . $book->getTitre());

    return new \Symfony\Component\HttpFoundation\RedirectResponse('/book');
} else {
    return new RedirectResponse(Authenticator::urlNotLogged());
}
