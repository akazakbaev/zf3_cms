<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;


use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;
use User\Strategy\DenyStrategy;


class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $application = $mvcEvent->getApplication();
        $serviceLocator = $application->getServiceManager();

        $eventManager = $application->getEventManager();

        $denyStrategy   = $serviceLocator->get(DenyStrategy::class);

        $denyStrategy->attach($eventManager);

    }
}
