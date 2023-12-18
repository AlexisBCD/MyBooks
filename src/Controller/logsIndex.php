<?php


/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 */

use Entity\Log;
use Security\Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;


if (Authenticator::is_authenticated()) {
    $LogsRepository = $entityManager->getRepository(Log::class);
    $Logs = $LogsRepository->findAll();
    return new Response($twig->render('logs/index.html.twig', ['logs' => $Logs]));
} else {
    return new RedirectResponse(Authenticator::urlNotLogged());
}
