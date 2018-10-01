<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/22/18
 * Time: 12:08 PM
 */
namespace Application\Provider;

interface ItemEntityInterface
{
    public function getItemType();

    public function getIdentity();

    public function getTitle();
    
    public function getHref();
}