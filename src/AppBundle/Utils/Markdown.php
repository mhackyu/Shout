<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 10/17/17
 * Time: 11:42 PM
 */

namespace AppBundle\Utils;


class Markdown
{
    private $parser;

    public function __construct()
    {
        $this->parser = new \Parsedown();
    }

    public function toHtml($text)
    {
        $html = $this->parser->text($text);

        return $html;
    }
}