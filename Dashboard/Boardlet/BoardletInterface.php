<?php

namespace Havvg\Bundle\DashboardBundle\Dashboard\Boardlet;

interface BoardletInterface
{
    /**
     * Return a unique identifier among all known boardlets.
     *
     * @return string
     */
    public function getId();

    /**
     * Return the name of this boardlet.
     *
     * @return string
     */
    public function getName();

    /**
     * Return a description of the boardlet.
     *
     * @return string
     */
    public function getDescription();

    /**
     * Return the data attached to this boardlet.
     *
     * This data is contracted to a configured renderer displaying this boardlet.
     *
     * @return mixed
     */
    public function getData();
}
