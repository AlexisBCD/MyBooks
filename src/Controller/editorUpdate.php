<?php

namespace Logger;

use Monolog\Logger;
use Security\Authenticator;
use Logger\CentralizedHandler;
use Entity\Editor;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var Request $request
 * @var int $id
 * @var ValidatorInterface $validator
 **/


$arrayViolations = [];

// ...

if (Authenticator::is_authenticated()) {
    $editorRepository = $entityManager->getRepository(Editor::class);
    $editor = $editorRepository->find($id);

    if (!$editor) {
        // Gérer le cas où l'éditeur n'est pas trouvé
        // Par exemple, afficher un message d'erreur ou rediriger
    } else if (Request::METHOD_POST == $request->getMethod()) {
        // Mise à jour de l'éditeur existant
        $editor->setAdresse($request->get('adresse'))
            ->setEmail($request->get('email'))
            ->setName($request->get('nom'))
            ->setTel($request->get('tel'));

        $editorViolations = $validator->validate($editor);

        if (count($editorViolations) === 0) {
            $entityManager->flush();

            $customHandler = new CentralizedHandler($entityManager);
            $logger = new Logger('app');
            $logger->pushHandler($customHandler);
            $logger->info('Éditeur mis à jour par ' . Authenticator::getUser() . ' : ' . $editor->getName());

            return new RedirectResponse('/editor');
        } else {
            foreach ($editorViolations as $violation) {
                $arrayViolations[$violation->getPropertyPath()][] = $violation->getMessage();
            }
        }
    }

    return new Response($twig->render('editor/update.html.twig', ['editor' => $editor, 'violations' => $arrayViolations]));
} else {
    return new RedirectResponse(Authenticator::urlNotLogged());
}
