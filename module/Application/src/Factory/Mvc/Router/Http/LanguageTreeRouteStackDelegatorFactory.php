<?php

namespace Application\Factory\Mvc\Router\Http;

use Zend\ServiceManager\Factory\DelegatorFactoryInterface;
use Interop\Container\ContainerInterface;
use Application\Mvc\Router\Http\LanguageTreeRouteStack;
use Application\Options\LanguageOptions;
use User\Service\AuthManager;
/**
 * Description of LanguageTreeRouteStackDelegatorFactory
 *
 * @author schurix
 */
class LanguageTreeRouteStackDelegatorFactory implements DelegatorFactoryInterface{
	public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
		$router = $callback();

		if(!$router instanceof LanguageTreeRouteStack){
			return $router;
		}

		if($container->has(\Application\Options\LanguageOptions::class))
		{
			$router->setLanguageOptions($container->get(\Application\Options\LanguageOptions::class));
		}
		
		if($container->has(AuthManager::class)){
			$router->setAuthManager($container->get(AuthManager::class));
		}
		
		return $router;
	}
}
