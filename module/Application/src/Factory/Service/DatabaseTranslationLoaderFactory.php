<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/16/18
 * Time: 8:39 AM
 */
namespace Application\Factory\Service;

use Application\Service\CacheManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\DatabaseTranslationLoader;

class DatabaseTranslationLoaderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
//        var_dump($container);die;

        $entityManager = null;

        if($container->has('doctrine.entitymanager.orm_default'))
            $entityManager = $container->get('doctrine.entitymanager.orm_default');

        if($container->has('MvcTranslator'))
            $translator = $container->get('MvcTranslator');

        $cache = $container->get(CacheManager::class)->getCache();

        return new DatabaseTranslationLoader($entityManager, $translator, $cache);
    }
}