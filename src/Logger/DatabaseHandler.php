<?php

namespace Logger;

use Entity\Log;
use Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Monolog\Handler\AbstractProcessingHandler;
use Symfony\Component\Security\Core\Security;

class DatabaseHandler extends AbstractProcessingHandler
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
        $log = new Log();
        $log->setMessage($record['message']);

        $this->entityManager->persist($log);
        $this->entityManager->flush();
    }
}
