<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev
 * Date: 6/27/17
 * Time: 11:52 AM
 */
namespace Application\Factory\Service;


use Application\Classes\Navigation;


/**
 * Admin navigation factory.
 */
class MainNavigationFactory extends Navigation
{
    /**
     * @return string
     */
    protected function getName()
    {
        return 'default';
    }
}