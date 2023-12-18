<?php

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var Request $request
 * @var ValidatorInterface $validator
 */


use Entity\Editor;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Monolog\Logger;
use Security\Authenticator;
use Logger\DatabaseHandler;

$editorRepository = $entityManager->getRepository(Editor::class);

$arrayViolations = [];

if (Request::METHOD_POST == $request->getMethod()) {
    $editor = (new Editor())
        ->setAdresse($request->get('adresse'))
        ->setEmail($request->get('email'))
        ->setNom($request->get('nom'))
        ->setTel($request->get('tel'));

    $violations = $validator->validate($editor);

    if ($violations->count() == 0) {
        $entityManager->persist($editor);
        $entityManager->flush();

        $customHandler = new DatabaseHandler($entityManager);
        $logger = new Logger('app');
        $logger->pushHandler($customHandler);
        $logger->info('Nouveau éditeur ajouté par ' . Authenticator::getUser() . ' : ' . $editor->getNom());

        return new RedirectResponse('/editor');
    }
    foreach ($violations as $violation) {
        $arrayViolations[$violation->getPropertyPath()][] = $violation->getMessage();
    }
}

return new Response($twig->render('editor/new.html.twig', ['violations' => $arrayViolations]));
