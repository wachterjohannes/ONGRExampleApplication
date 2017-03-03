<?php

namespace AppBundle\Infrastructure;

use AppBundle\Item\ItemRepositoryInterface;
use Doctrine\ORM\EntityRepository;

class ItemRepository extends EntityRepository implements ItemRepositoryInterface
{
    public function findItems($page = 1, $pageSize = 10, $query = null)
    {
        $queryBuilder = $this->createQueryBuilder('item')
            ->orderBy('item.createdAt', 'desc')
            ->setFirstResult(($page - 1) * $pageSize)
            ->setMaxResults($pageSize);

        if($query) {
            $queryBuilder->where('item.title LIKE :query')->setParameter('query', '%' . $query . '%');
        }

        return $queryBuilder->getQuery()->getResult();
    }

    public function count($query = null)
    {
        $queryBuilder= $this->createQueryBuilder('item')
            ->select('count(item.id) AS itemCount');

        if($query) {
            $queryBuilder->where('item.title LIKE :query')->setParameter('query', '%' . $query . '%');
        }

        return $queryBuilder->getQuery()->getSingleScalarResult();
    }

    public function save(Item $item)
    {
        $this->_em->persist($item);
    }

    public function remove($id)
    {
        $this->_em->remove($this->find($id));
    }
}
