<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/21/18
 * Time: 1:16 PM
 */
namespace Storage;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
}