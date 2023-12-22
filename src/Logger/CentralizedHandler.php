<?php

namespace Logger;

use Monolog\Handler\AbstractProcessingHandler;
use Logger\WebhookHandler;
use Logger\DatabaseHandler;
use Doctrine\ORM\EntityManagerInterface;

class CentralizedHandler extends AbstractProcessingHandler
{
    /**
     * @var EntityManagerInterface
     */
    private $webhookHandler;
    private $databaseHandler;
    private $entityManager;

    public function __construct(
        EntityManagerInterface $entityManager,
    ) {
        parent::__construct();
        $this->entityManager = $entityManager;
        // Créer des instances des handlers spécifiques
        $this->webhookHandler = new WebhookHandler($entityManager);
        $this->databaseHandler = new DatabaseHandler($entityManager);
    }

    protected function write($record): void
    {
        // Appeler le WebhookHandler
        $this->webhookHandler->handle($record);

        // Appeler le DatabaseHandler
        $this->databaseHandler->handle($record);
    }
}
