<?php

namespace AppBundle\Item;

use AppBundle\Entity\Item;

interface ItemIndexerInterface
{
    public function index(Item $item);

    public function remove($id);

    public function findItems($page = 1, $pageSize = 10, $query = null, $filter = null);
}
