<?php

namespace AppBundle\Item;

use AppBundle\Entity\Item;

interface ItemRepositoryInterface
{
    public function findItems($page = 1, $pageSize = 10);

    public function count($query = null);

    public function save(Item $item);

    public function remove($id);
}
