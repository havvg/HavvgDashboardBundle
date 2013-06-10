<?php

namespace Havvg\Bundle\DashboardBundle\Dashboard;

use Havvg\Bundle\DashboardBundle\Dashboard\Boardlet\BoardletInterface;

class Dashboard implements \IteratorAggregate, DashboardInterface
{
    /**
     * @var BoardletInterface[]
     */
    protected $boardlets = array();

    public function add(BoardletInterface $boardlet)
    {
        $this->boardlets[$boardlet->getId()] = $boardlet;

        return $this;
    }

    public function remove(BoardletInterface $boardlet)
    {
        unset($this->boardlets[$boardlet->getId()]);

        return $this;
    }

    public function getIterator()
    {
        return new \ArrayIterator($this->boardlets);
    }

    public function count()
    {
        return count($this->boardlets);
    }
}
