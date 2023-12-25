<?php

/**
 * @var Twig\Environment $twig
 * @var Doctrine\ORM\EntityManager $entityManager
 * @var Request $request
 * @var ValidatorInterface $validator
 */

use Monolog\Logger;
use Logger\CentralizedHandler;
use Security\Authenticator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Entity\Config; // Assurez-vous d'importer l'entité Config ici

if (Authenticator::is_authenticated()) {
    $allConfigs = $entityManager->getRepository(Config::class)->findAll();

    $allConfigsArray = [];
    foreach ($allConfigs as $config) {
        $allConfigsArray[$config->getSettingName()] = $config;
    }

    $arrayViolations = [];
    $logger = new Logger('app'); // Créez une instance de logger

    if (Request::METHOD_POST == $request->getMethod()) {
        $postData = $request->request->all(); // Récupérez toutes les clés et valeurs du POST

        foreach ($postData as $key => $value) {
            // Vérifiez si un enregistrement avec le même SettingName existe déjà
            $existingConfig = $entityManager->getRepository(Config::class)->findOneBy(['settingName' => $key]);

            if ($existingConfig) {
                // Mise à jour de l'enregistrement existant
                $existingConfig->setSettingValue($value);
                $config = $existingConfig;
            } else {
                // Création d'une nouvelle entité Config
                $config = new Config();
                $config->setSettingName($key);
                $config->setSettingValue($value);
            }

            // Validez l'entité Config
            $configViolations = $validator->validate($config);

            if (count($configViolations) === 0) {
                $entityManager->persist($config);
            } else {
                foreach ($configViolations as $violation) {
                    $arrayViolations[$violation->getPropertyPath()][] = $violation->getMessage();
                }
            }
        }

        $entityManager->flush();

        $customHandler = new CentralizedHandler($entityManager);
        $logger = new Logger('app');
        $logger->pushHandler($customHandler);
        $logger->info('Config mise à jour par ' . Authenticator::getUser());

        return new \Symfony\Component\HttpFoundation\RedirectResponse('/config');
    }

    return new Response($twig->render('config/index.html.twig', [
        'allConfigs' => $allConfigsArray,
        'violations' => $arrayViolations
    ]));
} else {
    return new RedirectResponse(Authenticator::urlNotLogged());
}
