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
     * @var ItemIndexer
     */
    private $itemIndexer;

    /**
     * @param EntityManagerInterface $entityManager
     * @param ItemIndexer $itemIndexer
     */
    public function __construct(EntityManagerInterface $entityManager, ItemIndexer $itemIndexer)
    {
        $this->entityManager = $entityManager;
        $this->itemIndexer = $itemIndexer;
    }

    public function onKernelResponse()
    {
        $this->entityManager->flush();
        $this->itemIndexer->flush();
    }
}
