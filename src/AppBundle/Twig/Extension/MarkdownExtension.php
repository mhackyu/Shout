<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 10/17/17
 * Time: 11:44 PM
 */

namespace AppBundle\Twig\Extension;

use AppBundle\Utils\Markdown;

class MarkdownExtension extends \Twig_Extension
{
    private $parser;

    public function __construct(Markdown $parser)
    {
        $this->parser = $parser;
    }

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter(
                'md2html',
                array($this, 'markdownToHtml'),
                array('is_safe' => array('html'), 'pre_escape' => 'html')
            ),
        );
    }

    public function markdownToHtml($content)
    {
        return $this->parser->toHtml($content);
    }

    public function getName()
    {
        return 'markdown_extension';
    }
}