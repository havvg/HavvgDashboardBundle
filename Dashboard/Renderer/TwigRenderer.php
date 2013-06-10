<?php

namespace Havvg\Bundle\DashboardBundle\Dashboard\Renderer;

use Havvg\Bundle\DashboardBundle\Dashboard\Boardlet\BoardletInterface;

use Havvg\Bundle\DashboardBundle\Exception\Renderer\ConfigurationException;
use Havvg\Bundle\DashboardBundle\Exception\Renderer\LogicException;

use Havvg\Bundle\DRYBundle\Twig\Extension\ExtensionTrait;

class TwigRenderer implements RendererInterface, \Twig_ExtensionInterface
{
    use ExtensionTrait;

    const OPTION_TEMPLATE = 'template';
    const OPTION_DEFAULT_BLOCK = 'default_block';

    /**
     * @var \Twig_Environment
     */
    protected $twig;

    /**
     * @var \Twig_Template
     */
    protected $template;

    protected $options = array();
    protected $hasDefaultBlock = false;

    /**
     * Configure this renderer.
     *
     * Options:
     *   * template - The Twig template to use, required.
     *   * default_block - The name of the block to use, if no boardlet specific block is found.
     *
     * @param array $options
     *
     * @return TwigRenderer
     *
     * @throws ConfigurationException
     */
    public function configure(array $options = array())
    {
        if (empty($options[self::OPTION_TEMPLATE])) {
            throw new ConfigurationException('No template defined. Please add the required "template" option.');
        }

        $this->template = $options[self::OPTION_TEMPLATE];
        $this->hasDefaultBlock = isset($options[self::OPTION_DEFAULT_BLOCK]);
        $this->verifyDefaultBlock();

        $this->options = $options;

        return $this;
    }

    /**
     * Check whether this renderer is capable of rendering the boardlet.
     *
     * @param BoardletInterface $boardlet
     *
     * @return bool
     */
    public function supports(BoardletInterface $boardlet)
    {
        try {
            $this->getBlockName($boardlet);

            return true;
        } catch (LogicException $e) {
            return false;
        }
    }

    /**
     * Render the configured template.
     *
     * @param BoardletInterface $boardlet
     * @param array             $options
     *
     * @return string
     */
    public function render(BoardletInterface $boardlet, array $options = array())
    {
        return $this->template->renderBlock($this->getBlockName($boardlet), array_merge($options, array(
            'boardlet' => $boardlet,
        )));
    }

    /**
     * Return the name of the Twig block to render the given boardlet.
     *
     * @param BoardletInterface $boardlet
     *
     * @return string
     */
    protected function getBoardletBlockName(BoardletInterface $boardlet)
    {
        $results = array();
        preg_match_all('/[A-Z][^A-Z]*/', $boardlet->getName(), $results);

        return 'boardlet_'.strtolower(implode('_', $results[0]));
    }

    /**
     * Return the name of the Twig block to be rendered.
     *
     * @param BoardletInterface $boardlet
     *
     * @return string
     *
     * @throws LogicException
     */
    protected function getBlockName(BoardletInterface $boardlet)
    {
        if ($this->template->hasBlock($this->getBoardletBlockName($boardlet))) {
            return $this->getBoardletBlockName($boardlet);
        }

        if ($this->hasDefaultBlock) {
            return $this->options[self::OPTION_DEFAULT_BLOCK];
        }

        throw new LogicException('Neither the boardlet specific block nor a default block could be found.');
    }

    protected function verifyDefaultBlock()
    {
        if ($this->hasDefaultBlock and $this->template instanceof \Twig_Template and !$this->template->hasBlock($this->options[self::OPTION_DEFAULT_BLOCK])) {
            throw new ConfigurationException('The default block is not part of the template.');
        }
    }

    public function initRuntime(\Twig_Environment $environment)
    {
        $this->twig = $environment;

        if (!$this->template instanceof \Twig_Template) {
            $this->template = $this->twig->loadTemplate($this->template);
            $this->verifyDefaultBlock();
        }
    }

    public function getFunctions()
    {
        return array(
            new \Twig_SimpleFunction('havvg_dashboard_render', array($this, 'render'), array('is_safe' => array('html'))),
        );
    }

    public function getName()
    {
        return 'havvg_dashboard';
    }
}
