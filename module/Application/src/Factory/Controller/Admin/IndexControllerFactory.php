<?php
namespace Application\Factory\Controller\Admin;

use Application\Controller\Admin\IndexController;
use Interop\Container\ContainerInterface;

use Zend\ServiceManager\Factory\FactoryInterface;
use User\Service\AuthManager;
use User\Service\UserManager;

/**
 * This is the factory for AuthController. Its purpose is to instantiate the controller
 * and inject dependencies into its constructor.
 */
class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        return new IndexController();
    }
}
