<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev
 * Date: 5/15/17
 * Time: 3:51 PM
 */
namespace User\Factory\Controller\Plugin;


use Interop\Container\ContainerInterface;
use User\Controller\Plugin\Viewer;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Service\AuthManager;

class ViewerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $authManager = $container->get(AuthManager::class);

        $auth  = new Viewer($authManager);

        return $auth;
    }
}