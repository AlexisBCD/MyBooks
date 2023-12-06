<?php

use Entity\Editor;
use Security\Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var int $id
 */

Authenticator::init();

if (Authenticator::is_authenticated()) {
    $editorRepository = $entityManager->getRepository(Editor::class);
    $editor = $editorRepository->find($id);
    $entityManager->remove($editor);
    $entityManager->flush();

    return new \Symfony\Component\HttpFoundation\RedirectResponse('/editor');
} else {
    return new RedirectResponse(Authenticator::urlNotLogged());
}
