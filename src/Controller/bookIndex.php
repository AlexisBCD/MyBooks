<?php

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 */

use Entity\Book;
use Entity\Editor; // Assurez-vous d'importer la classe Editor s'il n'est pas déjà importé
use Symfony\Component\HttpFoundation\Response;

$bookRepository = $entityManager->getRepository(Book::class);
$books = $bookRepository->findAll();

// Récupérez les éditeurs correspondants aux livres
$editorRepository = $entityManager->getRepository(Editor::class);
$editors = $editorRepository->findAll();

return new Response($twig->render('book/index.html.twig', ['books' => $books, 'editors' => $editors]));
