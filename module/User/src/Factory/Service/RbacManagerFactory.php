<?php
namespace User\Factory\Service;

use Interop\Container\ContainerInterface;
use User\Service\RbacManager;
use User\Service\AuthManager;
use Zf\Infocom\Core\Service\CacheManager;
/**
 * This is the factory class for RbacManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class RbacManagerFactory
{
    /**
     * This method creates the RbacManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $authManager = $container->get(AuthManager::class);
        $cache = $container->get(CacheManager::class)->getCache();
        
        $assertionManagers = [];
        $config = $container->get('Config');

        if (isset($config['rbac_manager']['assertions']))
        {
            foreach ($config['rbac_manager']['assertions'] as $serviceName)
            {
                $assertionManagers[$serviceName] = $container->get($serviceName);
            }
        }
        
        return new RbacManager($entityManager, $authManager, $cache, $assertionManagers);
    }
}

