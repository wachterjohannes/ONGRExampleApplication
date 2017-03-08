<?php

namespace AppBundle\Infrastructure;

use AppBundle\Document\ItemDocument;
use AppBundle\Entity\Item;
use AppBundle\Item\ItemIndexerInterface;
use ONGR\ElasticsearchBundle\Service\Manager;
use ONGR\ElasticsearchDSL\Query\Compound\BoolQuery;
use ONGR\ElasticsearchDSL\Query\FullText\MatchQuery;
use ONGR\ElasticsearchDSL\Query\MatchAllQuery;
use ONGR\ElasticsearchDSL\Query\TermLevel\TermQuery;
use ONGR\ElasticsearchDSL\Search;
use ONGR\ElasticsearchDSL\Sort\FieldSort;

class ItemIndexer implements ItemIndexerInterface
{
    /**
     * @var Manager
     */
    private $elasticsearchManager;

    /**
     * @var Item[]
     */
    private $indexCache = [];

    /**
     * @param Manager $elasticsearchManager
     */
    public function __construct(Manager $elasticsearchManager)
    {
        $this->elasticsearchManager = $elasticsearchManager;
    }

    public function index(Item $item)
    {
        $this->indexCache[] = $item;
    }

    public function remove($id)
    {
        if (!$itemDocument = $this->elasticsearchManager->find(ItemDocument::class, $id)) {
            return;
        }

        $this->elasticsearchManager->remove($itemDocument);
    }

    public function findItems($page = 1, $pageSize = 10, $queryString = null, $filter = null)
    {
        $query = new MatchAllQuery();
        if ($queryString) {
            $query = new MatchQuery('title', $queryString, ['fuzziness' => 'AUTO']);
        }

        $search = new Search();
        $search->addQuery($query);

        if ($filter) {
            $search->addQuery(new TermQuery('firstLetter', $filter), BoolQuery::FILTER);
        }

        $search->setFrom(($page - 1) * $pageSize);
        $search->setSize($pageSize);

        if (!$query) {
            $search->addSort(new FieldSort('createdAt', 'desc'));
        }

        return $this->elasticsearchManager->execute(['AppBundle:ItemDocument'], $search);
    }

    public function flush()
    {
        foreach ($this->indexCache as $item) {
            if (!$itemDocument = $this->elasticsearchManager->find(ItemDocument::class, $item->getId())) {
                $itemDocument = new ItemDocument();
                $itemDocument->setId($item->getId());
            }

            $itemDocument->setTitle($item->getTitle());
            $itemDocument->setCreatedAt($item->getCreatedAt());
            $itemDocument->setFirstLetter(strtolower(substr($item->getTitle(), 0, 1)));

            $this->elasticsearchManager->persist($itemDocument);
        }

        $this->elasticsearchManager->commit();

        $this->indexCache = [];
    }
}
