<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 3/9/18
 * Time: 2:52 PM
 */
namespace Application\Factory\View;
use Application\Options\LanguageOptions;
use Zend\ServiceManager\Factory\FactoryInterface;
use Interop\Container\ContainerInterface;

class LanguageSwitchFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {

        if(!$container->has(LanguageOptions::class))
        {
            return null;
        }

        $languageOptions = $container->get(LanguageOptions::class);
        $routeMatch = $container->get('Application')->getMvcEvent()->getRouteMatch();
        return new $requestedName($languageOptions, $routeMatch);
    }
}