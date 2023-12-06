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
        return isset($_SESSION['user']);
    }

    public static function authenticate($username, $password, $entityManager)
    {
        self::init();
        $userRepository = $entityManager->getRepository(User::class);
        $user = $userRepository->findOneBy(['username' => $username]);

        if ($user && password_verify($password, $user->getPassword())) {
            session_start();
            $_SESSION['user'] = password_hash($user->getID(), PASSWORD_BCRYPT);
            $_SESSION['username'] = $user->getUsername;
            return $user;
        } else {
            return null;
        }
    }
}
