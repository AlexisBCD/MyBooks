<?php


 /**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 */

use Entity\Editor;
use Symfony\Component\HttpFoundation\Response;

$editorRepository = $entityManager->getRepository(Editor::class);
$editors= $editorRepository->findAll();

return new Response($twig->render('book/index.html.twig', ['editors' => $editors]));


?>