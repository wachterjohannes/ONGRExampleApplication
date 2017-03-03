<?php

namespace AppBundle\Infrastructure;

use Doctrine\ORM\EntityManagerInterface;

class FlushSubscriber
{
    /**
     * @var EntityManagerInterface
     */
    private $entityManager;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function onKernelResponse()
    {
        $this->entityManager->flush();
    }
}
