<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev
 * Date: 5/17/17
 * Time: 10:33 AM
 */
namespace User\Factory\Strategy;

use Interop\Container\ContainerInterface;
use Zend\Mvc\View\Http\RouteNotFoundStrategy;
use Zend\ServiceManager\Factory\FactoryInterface;
use User\Strategy\DenyStrategy;
use User\Service\AuthManager;

class DenyStrategyFactory implements FactoryInterface
{
    /**
     * @param  ContainerInterface $container
     * @param  string $name
     * @param  null|array $options
     * @return RouteNotFoundStrategy
     */
    public function __invoke(ContainerInterface $container, $name, array $options = null)
    {
        $authManager = $container->get(AuthManager::class);

        return new DenyStrategy($authManager);
    }

}