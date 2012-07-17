<?php

namespace Havvg\Bundle\DashboardBundle\Dashboard\Renderer;

use Havvg\Bundle\DashboardBundle\Dashboard\Boardlet\BoardletInterface;

use Havvg\Bundle\DashboardBundle\Exception\ExceptionInterface;
use Havvg\Bundle\DashboardBundle\Exception\Renderer\ConfigurationException;
use Havvg\Bundle\DashboardBundle\Exception\Renderer\LogicException;
use Havvg\Bundle\DashboardBundle\Exception\Renderer\UnsupportedBoardletException;

interface RendererInterface
{
    /**
     * Configure the renderers options, if any.
     *
     * @param array $options
     *
     * @return RendererInterface
     *
     * @throws ConfigurationException
     */
    public function configure(array $options = array());

    /**
     * Check whether this renderer is capable of rendering the boardlet.
     *
     * @param BoardletInterface $boardlet
     *
     * @return bool
     */
    public function supports(BoardletInterface $boardlet);

    /**
     * Render the given boardlet.
     *
     * The rendering result may be a string e.g. a rendered template.
     * The result may have contracts to the handler of the renderer.
     *
     * The actual returned data type and structure depends on the renderers purpose.
     *
     * @param BoardletInterface $boardlet
     * @param array             $options  Additional rendering specific options.
     *
     * @return mixed
     *
     * @throws LogicException
     * @throws UnsupportedBoardletException
     * @throws ExceptionInterface
     */
    public function render(BoardletInterface $boardlet, array $options = array());
}
