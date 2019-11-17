<?php
namespace Application\Factory\View;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\SettingsManager;
use Application\View\Helper\Settings;
/**
 * This is the factory class for AuthManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class SettingsFactory implements FactoryInterface
{
    /**
     * This method creates the AuthManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        $settingsManager = $container->get(SettingsManager::class);


        // Instantiate the AuthManager service and inject dependencies to its constructor.
        return new Settings($settingsManager);
    }
}
