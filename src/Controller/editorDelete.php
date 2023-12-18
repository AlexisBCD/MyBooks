<?php

use Entity\Editor;
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
    $editorRepository = $entityManager->getRepository(Editor::class);
    $editor = $editorRepository->find($id);
    $entityManager->remove($editor);
    $entityManager->flush();

    $customHandler = new DatabaseHandler($entityManager);
    $logger = new Logger('app');
    $logger->pushHandler($customHandler);
    $logger->info('Editeur supprimé par ' . Authenticator::getUser() . ' : ' . $editor->getNom());

    return new \Symfony\Component\HttpFoundation\RedirectResponse('/editor');
} else {
    return new RedirectResponse(Authenticator::urlNotLogged());
}
