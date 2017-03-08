<?php

namespace AppBundle\Item;

use AppBundle\Entity\Item;

interface ItemRepositoryInterface
{
    public function findItems($page = 1, $pageSize = 10, $query = null, $filter = null);

    public function count($query = null, $filter = null);

    public function save(Item $item);

    public function remove($id);
}
