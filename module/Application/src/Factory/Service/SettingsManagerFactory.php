<?php
namespace Application\Factory\Service;

use Interop\Container\ContainerInterface;
use Application\Service\SettingsManager;
use Application\Service\CacheManager;

class SettingsManagerFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $cache = $container->get(CacheManager::class)->getCache();
        
        return new SettingsManager($entityManager, $cache);
    }
}

