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
     * @param ItemRepositoryInterface $repository
     */
    public function __construct(ItemRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function create(Item $item)
    {
        $this->repository->save($item);
    }

    public function remove($id)
    {
        $this->repository->remove($id);
    }
}
