<?php
/**
 * Created by JetBrains PhpStorm.
 * User: azim
 * Date: 9/19/13
 * Time: 5:09 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHtmlElement;

class HtmlLink extends AbstractHtmlElement
{
    public function __invoke($href = null, $content = "", $attribs = array())
    {
        $view = $this->getView();
        if( 0 == func_num_args() ) {
            return $this;
        }

        // You can give href an array to use router
        if( is_array($href) )
        {
            $route = $href['route'];
            unset($href['route']);

            $query = [];

            if(isset($href['query_params']))
            {
                $query = $href['query_params'];

                unset($href['query_params']);
            }

            $href = $view->url($route, $href, $query);
        }

        // $href is an object with a getHref() method
        else if( is_object($href) && method_exists($href, 'getHref') )
        {
            $href = $href->getHref();
        }

        if( null !== $href ) {
            $attribs = array_merge(array(
                'href' => $href
            ), $attribs);
        }

        // Merge data and type
        return '<a ' . $this->htmlAttribs($attribs) . '>' . $content . '</a>';
    }
}