<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Factory\Service\DatabaseTranslationLoaderFactory;
use Application\Listener\ServiceManagerListener;
use Application\Service\DatabaseTranslationLoader;
use Zend\Mvc\MvcEvent;
use Zend\I18n\Translator\LoaderPluginManager;
use Application\Listener\RouteListener;

use Zend\ModuleManager\ModuleManager;

class Module
{
    const VERSION = '3.0.3-dev';

    public function init(ModuleManager $manager)
    {
        date_default_timezone_set('Asia/Bishkek');

        if (function_exists('mb_internal_encoding'))
        {
            mb_internal_encoding("UTF-8");
        }

    }

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function onBootstrap(MvcEvent $e)
    {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();

        $routeListener = $serviceManager->get(RouteListener::class);

        $routeListener->onRoute($e);

        $em = $serviceManager->get('doctrine.entitymanager.orm_default');

        $dem = $em->getEventManager();

        $dem->addEventListener(array(\Doctrine\ORM\Events::postLoad), new ServiceManagerListener($serviceManager));
        $dem->addEventListener(array(\Doctrine\ORM\Events::postPersist), new ServiceManagerListener($serviceManager));

        $eventManager = $application->getEventManager();

        $routeListener = $serviceManager->get(RouteListener::class);

        $routeListener->onRoute($e);

        $eventManager->attach(MvcEvent::EVENT_DISPATCH, array($this, 'initLocale'), 100);
    }

    public function initLocale(MvcEvent $e)
    {
        $sm = $e->getApplication()->getServiceManager();

        /**
         * @var $translator \Zend\Mvc\I18n\Translator
         */
        $translator = $sm->get('MvcTranslator');

        $translator->setPluginManager(new LoaderPluginManager($sm));

        $translator->getPluginManager()->setFactory(DatabaseTranslationLoader::class, DatabaseTranslationLoaderFactory::class);

        $translator->addRemoteTranslations(DatabaseTranslationLoader::class);

        $languagesOptions =  $sm->get(Options\LanguageOptions::class);

        $languages = $languagesOptions->getLanguages();

        $locale = $languagesOptions->getDefaultLocale();

        if($e->getRouteMatch() !== null)
        {
            $routeLocale = $e->getRouteMatch()->getParam('locale', false);

            if($routeLocale && (array_key_exists($routeLocale, $languages) || (array_search($routeLocale, $languages))) && count($languages) > 1)
                $locale = $routeLocale;

        }

        $translator->setLocale($locale);
        \Locale::setDefault($locale);

    }
}
