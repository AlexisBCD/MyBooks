<?php

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var Request $request
 * @var ValidatorInterface $validator
 */


use Security\Authenticator;
use Entity\Book;
use Entity\Editor;
use Logger\DatabaseHandler;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Monolog\Logger;

if (Authenticator::is_authenticated()) {
    $editorRepository = $entityManager->getRepository(Editor::class);
    $editors = $editorRepository->findAll();

    $arrayViolations = [];
    $logger = new Logger('app'); // Créez une instance de logger

    if (Request::METHOD_POST == $request->getMethod()) {
        // Modification pour utiliser l'ID de l'éditeur
        $editorId = $request->get('editor');
        $editor = $entityManager->find(Editor::class, $editorId);

        $book = (new Book())
            ->setTitre($request->get('title'))
            ->setAuteur($request->get('author'))
            ->setAnneePublication(new \DateTime($request->get('yearOfPublication')))
            ->setEditeur($editor) // Utilisation de l'objet Editor plutôt que de la chaîne
            ->setISBN($request->get('ISBN'));

        $violations = $validator->validate($book);

        if ($violations->count() == 0) {
            $entityManager->persist($book);
            $entityManager->flush();

            $customHandler = new DatabaseHandler($entityManager);
            $logger->pushHandler($customHandler);
            $logger->info('Nouveau livre ajouté par ' . Authenticator::getUser() . ' : ' . $book->getTitre());

            return new RedirectResponse('/book');
        }

        foreach ($violations as $violation) {
            $arrayViolations[$violation->getPropertyPath()][] = $violation->getMessage();
        }
    }

    return new Response($twig->render('book/new.html.twig', [
        'violations' => $arrayViolations,
        'editors' => $editors,
    ]));
} else {
    return new RedirectResponse(Authenticator::urlNotLogged());
}
