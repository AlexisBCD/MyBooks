<?php

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var Request $request
 * @var ValidatorInterface $validator
 */

namespace Security;

use Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class Authenticator
{
    public static function init()
    {
        session_start();
    }

    public static function is_authenticated()
    {
        return (isset($_SESSION['userId']) && isset($_SESSION['username']));
    }

    public static function authenticate($username, $password, $entityManager)
    {
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);

        if ($user && password_verify($password, $user->getPassword())) {
            $_SESSION['userId'] = password_hash($user->getID(), PASSWORD_BCRYPT);
            $_SESSION['username'] = $user->getUsername();
            return $user;
        } else {
            return null;
        }
    }

    public static function getUser()
    {
        return $_SESSION['username'];
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        return new RedirectResponse(Authenticator::urlNotLogged());
    }

    public static function urlNotLogged()
    {
        return '/login';
    }
}
//return new RedirectResponse('/');