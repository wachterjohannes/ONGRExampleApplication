<?php

namespace AppBundle\Document;

use ONGR\ElasticsearchBundle\Annotation as ES;

/**
 * @ES\Document
 */
class ItemDocument
{
    /**
     * @var int
     *
     * @ES\Id
     */
    private $id;

    /**
     * @var string
     *
     * @ES\Property(name="firstLetter", type="string", options={"analyzer": "keyword"})
     */
    private $firstLetter;

    /**
     * @var string
     *
     * @ES\Property(name="title", type="string")
     */
    private $title;

    /**
     * @var \DateTime
     *
     * @ES\Property(name="createdAt", type="date")
     */
    private $createdAt;

    /**
     * Returns id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set id.
     *
     * @param int $id
     *
     * @return $this
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Returns first-letter.
     *
     * @return string
     */
    public function getFirstLetter()
    {
        return $this->firstLetter;
    }

    /**
     * Set first-letter.
     *
     * @param string $firstLetter
     *
     * @return $this
     */
    public function setFirstLetter($firstLetter)
    {
        $this->firstLetter = $firstLetter;

        return $this;
    }

    /**
     * Returns title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Returns createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}
