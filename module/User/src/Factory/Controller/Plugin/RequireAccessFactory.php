<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev
 * Date: 5/15/17
 * Time: 3:51 PM
 */
namespace User\Factory\Controller\Plugin;


use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Service\RbacManager;
use User\Controller\Plugin\RequireAccess;

class RequireAccessFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $rbacManager = $container->get(RbacManager::class);
        $response = $container->get('ServiceManager')->get('Response');

        return new RequireAccess($rbacManager, $response);
    }
}