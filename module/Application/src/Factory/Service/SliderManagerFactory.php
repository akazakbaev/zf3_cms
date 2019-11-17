<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/12/18
 * Time: 3:22 PM
 */
namespace Application\Factory\Service;

use Application\Service\SliderManager;
use Interop\Container\ContainerInterface;
use Storage\Service\FileManager;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class SliderManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $fileManager = $container->get(FileManager::class);

        $controllerPluginManager = $container->get('ControllerPluginManager');
        $flashMessenger          = $controllerPluginManager->get('flashmessenger');

        // Instantiate the controller and inject dependencies
        return new SliderManager($entityManager, $fileManager, $flashMessenger);
    }
}