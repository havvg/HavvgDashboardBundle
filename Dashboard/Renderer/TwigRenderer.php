<?php

namespace Havvg\Bundle\DashboardBundle\Dashboard\Renderer;

use Twig_Environment;
use Twig_Template;

use Havvg\Bundle\DashboardBundle\Dashboard\Boardlet\BoardletInterface;

use Havvg\Bundle\DashboardBundle\Exception\Renderer\ConfigurationException;
use Havvg\Bundle\DashboardBundle\Exception\Renderer\LogicException;

class TwigRenderer implements RendererInterface
{
    const OPTION_TEMPLATE = 'template';
    const OPTION_DEFAULT_BLOCK = 'default_block';

    /**
     * @var Twig_Environment
     */
    protected $twig;

    /**
     * @var Twig_Template
     */
    protected $template;

    protected $options = array();
    protected $hasDefaultBlock = false;

    /**
     * Constructor.
     *
     * @param Twig_Environment $twig A pre-configured Twig environment.
     */
    public function __construct(Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

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
        if (!$this->template instanceof Twig_Template) {
            $this->template = $this->twig->loadTemplate($this->template);
        }

        $this->hasDefaultBlock = isset($options[self::OPTION_DEFAULT_BLOCK]);
        if ($this->hasDefaultBlock and !$this->template->hasBlock($options[self::OPTION_DEFAULT_BLOCK])) {
            throw new ConfigurationException('The default block is not part of the template.');
        }

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
}
