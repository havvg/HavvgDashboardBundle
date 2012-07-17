<?php

namespace Havvg\Bundle\DashboardBundle\Twig;

use Havvg\Bundle\DashboardBundle\Dashboard\Boardlet\BoardletInterface;
use Havvg\Bundle\DashboardBundle\Dashboard\Renderer\TwigRenderer;

class DashboardExtension extends \Twig_Extension
{
    protected $renderer;

    public function __construct(TwigRenderer $renderer)
    {
        $this->renderer = $renderer;
    }

    public function getFunctions()
    {
        return array(
            'havvg_dashboard_render' => new \Twig_Function_Method($this, 'render', array('is_safe' => array('html'))),
        );
    }

    public function render(BoardletInterface $boardlet, array $options = array())
    {
        return $this->renderer->render($boardlet, $options);
    }

    public function getName()
    {
        return 'havvg_dashboard';
    }
}
