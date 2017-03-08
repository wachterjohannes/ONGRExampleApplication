<?php

namespace AppBundle\Item;

use AppBundle\Entity\Item;

class ItemManager
{
    /**
     * @var ItemRepositoryInterface
     */
    private $repository;

    /**
     * @var ItemIndexerInterface
     */
    private $indexer;

    /**
     * @param ItemRepositoryInterface $repository
     * @param ItemIndexerInterface $indexer
     */
    public function __construct(ItemRepositoryInterface $repository, ItemIndexerInterface $indexer)
    {
        $this->repository = $repository;
        $this->indexer = $indexer;
    }

    public function create(Item $item)
    {
        $this->repository->save($item);
        $this->indexer->index($item);
    }

    public function remove($id)
    {
        $this->repository->remove($id);
        $this->indexer->remove($id);
    }
}
