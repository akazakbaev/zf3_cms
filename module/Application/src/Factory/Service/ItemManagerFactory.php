<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/12/18
 * Time: 3:22 PM
 */
namespace Application\Factory\Service;

use Application\Service\ItemManager;

use Interop\Container\ContainerInterface;
use Storage\Service\FileManager;
use User\Service\AuthManager;
use Zend\ServiceManager\Factory\FactoryInterface;

class ItemManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $fileManager = $container->get(FileManager::class);

        $controllerPluginManager = $container->get('ControllerPluginManager');
        $flashMessenger          = $controllerPluginManager->get('flashmessenger');
        $authManager = $container->get(AuthManager::class);

        return new ItemManager($entityManager, $fileManager, $flashMessenger, $authManager);
    }
}