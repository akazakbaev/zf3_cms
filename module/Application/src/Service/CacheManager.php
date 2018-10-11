<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 4/5/18
 * Time: 6:23 PM
 */
namespace Application\Service;
use Zend\Cache\StorageFactory;

/**
 * This service is responsible for initialzing RBAC (Role-Based Access Control).
 */
class CacheManager
{
    protected $cache;

    public function __construct($settings)
    {
       $this->cache = StorageFactory::factory($settings);
    }

    public function getCache()
    {
        return $this->cache;
    }
}