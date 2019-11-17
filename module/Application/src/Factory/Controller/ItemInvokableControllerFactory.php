<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/12/18
 * Time: 3:22 PM
 */
namespace Application\Factory\Controller;

use Application\Service\ItemManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class ItemInvokableControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $itemManager = $container->get(ItemManager::class);
        // Instantiate the controller and inject dependencies
        return new $requestedName($entityManager, $itemManager);
    }
}