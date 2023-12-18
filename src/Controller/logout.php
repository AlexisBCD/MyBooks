<?php

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var Request $request
 * @var ValidatorInterface $validator
 */


use Security\Authenticator;
use Logger\DatabaseHandler;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\RedirectResponse;

if (Authenticator::is_authenticated()) {
    $customHandler = new DatabaseHandler($entityManager);
    $logger = new Logger('app');
    $logger->pushHandler($customHandler);
    $logger->info(Authenticator::getUser() . " s'est déconnecté ");
    Authenticator::logout();
    return new RedirectResponse('/');
} else {
    return new RedirectResponse(Authenticator::urlNotLogged());
}
