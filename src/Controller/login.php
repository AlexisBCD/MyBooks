<?php

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var Request $request
 * @var ValidatorInterface $validator
 */


use Security\Authenticator;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;

Authenticator::init();

if (!Authenticator::is_authenticated()) {
    if ($request != null && $request->isMethod('POST')) {
        $username = $request->request->get('_username');
        $password = $request->request->get('_password');

        $user = Authenticator::authenticate($username, $password, $entityManager);
        if ($user != null) {
            return new RedirectResponse('/');
        } else {
            return new Response($twig->render('login/login.html.twig', [
                'last_username' => $username,
                'error'         => "Identifiants incorrects",
            ]));
        }
    } else {
        return new Response($twig->render('login/login.html.twig', [
            'last_username' => null,
            'error'         => null,
        ]));
    }
} else {
    return new RedirectResponse('/book');
}
