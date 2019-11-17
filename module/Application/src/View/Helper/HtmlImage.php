<?php
/**
 * Created by JetBrains PhpStorm.
 * User: azim
 * Date: 9/20/13
 * Time: 11:54 AM
 * To change this template use File | Settings | File Templates.
 */
namespace Application\View\Helper;

use Zend\View\Helper\AbstractHtmlElement;


class HtmlImage extends AbstractHtmlElement
{
    public function __invoke($src, $alt = "", $attribs = array())
    {
        // Allow passing an array
        if( is_array($src) )
        {
            $route = ( isset($src['route']) ? $src['route'] : 'default' );
            $reset = ( isset($src['reset']) ? $src['reset'] : false );
            unset($src['route']);
            unset($src['reset']);
            $src = $this->getView()->url($src, $route, $reset);
        }

        // Merge data and type
        $attribs = array_merge(array(
            'src' => $src,
            'alt' => $alt), $attribs);

        $closingBracket = $this->getClosingBracket();

        return '<img'.$this->htmlAttribs($attribs).$closingBracket;
    }
}