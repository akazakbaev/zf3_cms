<?php

namespace Application\Factory\Listener;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class RouteListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName,
        array $options = null
    ) {
        $router                 = $container->get('router');
        $request                = $container->get('request');
        $translator             = $container->get('translator');
//        $persistStrategyService = $container->get(
//            PersistStrategyService::class
//        );

        return new $requestedName(
            $router, $request, $translator
        );
    }
}
