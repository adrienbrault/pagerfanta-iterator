<?php

namespace AdrienBrault\PagerfantaIterator;

use Pagerfanta\Pagerfanta;

/**
 * @author Adrien Brault <adrien.brault@gmail.com>
 */
class PagerfantaIterator implements \Iterator
{
    /**
     * @var Pagerfanta
     */
    private $pager;

    private $currentPage;

    /**
     * @var int
     */
    private $startPage;

    public function __construct(Pagerfanta $pager, $startPage = 1)
    {
        $this->pager = clone $pager;
        $this->startPage = (int) $startPage;
        $this->rewind();
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->pager->getIterator();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->currentPage++;

        if ($this->valid()) {
            $this->pager->setCurrentPage($this->pager->getNextPage());
        }
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return $this->pager->getCurrentPage();
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->currentPage <= $this->pager->getNbPages();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->currentPage = $this->startPage;
        $this->pager->setCurrentPage($this->currentPage);
    }

    public static function iterateOverPages(Pagerfanta $pager, $startPage = null)
    {
        return new static($pager, $startPage);
    }

    public static function iterateOverElements(Pagerfanta $pager, $startPage = null)
    {
        return new IteratorIterator(static::iterateOverPages($pager, $startPage));
    }
}
