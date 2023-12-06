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
use Symfony\Component\Validator\Validator\ValidatorInterface;

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

        return new RedirectResponse('/editor');
    }
    foreach ($violations as $violation) {
        $arrayViolations[$violation->getPropertyPath()][] = $violation->getMessage();
    }
}

return new Response($twig->render('editor/new.html.twig', ['violations' => $arrayViolations]));