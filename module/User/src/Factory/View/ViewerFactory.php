<?php
namespace User\Factory\View;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Service\AuthManager;
use User\View\Helper\Viewer;
/**
 * This is the factory class for AuthManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class ViewerFactory implements FactoryInterface
{
    /**
     * This method creates the AuthManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $authManager = $container->get(AuthManager::class);


        // Instantiate the AuthManager service and inject dependencies to its constructor.
        return new Viewer($authManager);
    }
}
