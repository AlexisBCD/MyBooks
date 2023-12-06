<?php

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var int $id
 */

use Entity\Editor;
use Symfony\Component\HttpFoundation\Response;

$editorRepository = $entityManager->getRepository(Editor::class);
$editor = $editorRepository->find($id);

return new Response($twig->render('editor/show.html.twig', ['editor' => $editor]));
