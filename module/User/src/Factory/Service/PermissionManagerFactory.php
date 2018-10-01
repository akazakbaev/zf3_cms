<?php
namespace User\Factory\Service;

use Interop\Container\ContainerInterface;
use User\Service\AuthManager;
use User\Service\PermissionManager;
use User\Service\RbacManager;

/**
 * This is the factory class for UserManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class PermissionManagerFactory
{
    /**
     * This method creates the UserManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $authManager = $container->get(AuthManager::class);
        $rbacManager = $container->get(RbacManager::class);
        $translator = $container->get('MvcTranslator');

        return new PermissionManager($entityManager, $authManager, $rbacManager, $translator);
    }
}
