<?php
namespace Storage\Factory\Storage;

use Storage\Storage\Local;
use Interop\Container\ContainerInterface;


class LocalFactory
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');

        $options = [];

        if(isset($config['storage']) && isset($config['storage']['options']))
        {
            $options = $config['storage']['options'];
        }

        $route = $container->get('Router');

        return new Local($route, $options);
    }
}

