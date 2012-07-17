<?php

namespace Havvg\Bundle\DashboardBundle\Dashboard;

use Havvg\Bundle\DashboardBundle\Dashboard\Boardlet\BoardletInterface;

class Dashboard implements \Iterator, \Countable
{
    /**
     * @var BoardletInterface[]
     */
    protected $boardlets = array();

    /**
     * Add a new boardlet to this dashboard.
     *
     * @param BoardletInterface $boardlet
     *
     * @return Dashboard
     */
    public function add(BoardletInterface $boardlet)
    {
        $this->boardlets[$boardlet->getId()] = $boardlet;

        return $this;
    }

    /**
     * Remove a boardlet from this dashboard.
     *
     * @param BoardletInterface $boardlet
     *
     * @return Dashboard
     */
    public function remove(BoardletInterface $boardlet)
    {
        unset($this->boardlets[$boardlet->getId()]);

        return $this;
    }

    // Iterator implementation

    public function current()
    {
        return current($this->boardlets);
    }

    public function next()
    {
        next($this->boardlets);
    }

    public function key()
    {
        return key($this->boardlets);
    }

    public function valid()
    {
        return isset($this->boardlets[$this->key()]);
    }

    public function rewind()
    {
        reset($this->boardlets);
    }

    // Countable implementation

    public function count()
    {
        return count($this->boardlets);
    }
}
