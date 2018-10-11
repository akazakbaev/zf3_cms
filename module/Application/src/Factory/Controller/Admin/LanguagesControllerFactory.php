<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/12/18
 * Time: 3:22 PM
 */
namespace Application\Factory\Controller\Admin;

use Application\Controller\Admin\LanguagesController;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\Service\LanguageManager;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class LanguagesControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $languageManager = $container->get(LanguageManager::class);

        // Instantiate the controller and inject dependencies
        return new LanguagesController($entityManager, $languageManager);
    }
}