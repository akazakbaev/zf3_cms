<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Listener\ServiceManagerListener;
use Zend\Mvc\MvcEvent;

class Module
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        $em = $serviceManager->get('doctrine.entitymanager.orm_default');

        $dem = $em->getEventManager();

        $dem->addEventListener(array(\Doctrine\ORM\Events::postLoad), new ServiceManagerListener($serviceManager));
        $dem->addEventListener(array(\Doctrine\ORM\Events::postPersist), new ServiceManagerListener($serviceManager));
    }
}
