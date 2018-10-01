<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/12/18
 * Time: 3:22 PM
 */

namespace User\Factory\Controller;

use Interop\Container\ContainerInterface;
use User\Controller\ProfileController;
use User\Service\AuthManager;
use User\Service\UserManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class ProfileControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $userManager   = $container->get(UserManager::class);
        $authManager   = $container->get(AuthManager::class);

        // Instantiate the controller and inject dependencies
        return new ProfileController($entityManager, $userManager, $authManager);
    }
}