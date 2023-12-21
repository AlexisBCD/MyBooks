<?php

namespace Logger;

use Monolog\Handler\AbstractProcessingHandler;
use Doctrine\ORM\EntityManagerInterface;
use Monolog\Logger;
use Entity\Config;

class WebhookHandler extends AbstractProcessingHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
        $this->entityManager = $entityManager;
    }

    /**
     * @param array $record
     * @throws ORMException
     */
    protected function write($record): void
    {
        // Vérifier si les webhooks sont activés
        $webhookEnabled = $this->entityManager->getRepository(Config::class)->findOneBy(['settingName' => 'webhookEnabled']);
        if ($webhookEnabled && $webhookEnabled->getSettingValue() == 1) {
            // Récupérer l'URL du webhook
            $webhookUrl = $this->entityManager->getRepository(Config::class)->findOneBy(['settingName' => 'webhookInput']);
            if ($webhookUrl) {
                // Préparer le message pour Discord
                $postData = json_encode([
                    "username" => "MonLogger", // Nom d'utilisateur personnalisé pour le webhook
                    "content" => $record['message'], // Message du log
                    "embeds" => [
                        [
                            "title" => "Détails du Log", // Titre de l'embed
                            "type" => "rich", // Type d'embed
                            "description" => $record['formatted'], // Description avec plus de détails
                            "timestamp" => date("c"), // Timestamp actuel
                        ]
                    ]
                ]);

                // Utiliser cURL pour envoyer les données au webhook
                $ch = curl_init($webhookUrl->getSettingValue());
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, [
                    'Content-Type: application/json',
                    'Content-Length: ' . strlen($postData)
                ]);

                $result = curl_exec($ch);
                if ($result === false) {
                    // Gérer l'erreur ici
                    // par exemple : echo 'cURL Error: ' . curl_error($ch);
                }

                curl_close($ch);
            }
        }
    }
}
