<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/12/18
 * Time: 3:22 PM
 */
namespace Application\Factory\Controller\Admin;

use Application\Controller\Admin\TeamController;
use Application\Options\LanguageOptions;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class TeamControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $languageOptions = $container->get(LanguageOptions::class);
        // Instantiate the controller and inject dependencies
        return new TeamController($entityManager, $languageOptions);
    }
}