<?php

namespace Havvg\Bundle\DashboardBundle\Dashboard;

use Havvg\Bundle\DashboardBundle\Dashboard\Boardlet\BoardletInterface;

interface DashboardInterface extends \Traversable, \Countable
{
    /**
     * Add a new boardlet to this dashboard.
     *
     * @param BoardletInterface $boardlet
     *
     * @return DashboardInterface
     */
    public function add(BoardletInterface $boardlet);

    /**
     * Remove a boardlet from this dashboard.
     *
     * @param BoardletInterface $boardlet
     *
     * @return Dashboard
     */
    public function remove(BoardletInterface $boardlet);
}
