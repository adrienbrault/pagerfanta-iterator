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

    /**
     * @var \Iterator
     */
    private $currentPageIterator;

    public function __construct(Pagerfanta $pager)
    {
        $this->pager = clone $pager;
        $this->pager->setCurrentPage(1);
    }

    /**
     * {@inheritdoc}
     */
    public function current()
    {
        return $this->getCurrentPageIterator()->current();
    }

    /**
     * {@inheritdoc}
     */
    public function next()
    {
        $this->getCurrentPageIterator()->next();

        if (!$this->getCurrentPageIterator()->valid()
            && $this->pager->hasNextPage()) {
            $this->pager->setCurrentPage($this->pager->getNextPage());
            $this->currentPageIterator = $this->pager->getIterator();
        }
    }

    /**
     * {@inheritdoc}
     */
    public function key()
    {
        return
            $this->pager->getMaxPerPage()
            * ($this->pager->getCurrentPage() - 1)
            + $this->currentPageIterator->key()
        ;
    }

    /**
     * {@inheritdoc}
     */
    public function valid()
    {
        return $this->getCurrentPageIterator()->valid();
    }

    /**
     * {@inheritdoc}
     */
    public function rewind()
    {
        $this->pager->setCurrentPage(1);
    }

    private function getCurrentPageIterator()
    {
        if (null === $this->currentPageIterator) {
            $this->currentPageIterator = $this->pager->getIterator();
        }

        return $this->currentPageIterator;
    }
}
