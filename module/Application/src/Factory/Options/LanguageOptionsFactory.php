<?php

namespace Application\Factory\Options;

use Interop\Container\ContainerInterface;
use Application\Options\LanguageOptions;
use Zend\ServiceManager\Factory\FactoryInterface;

class LanguageOptionsFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName,
        array $options = null
    ) {
        $config = $container->get('Config');


        return new LanguageOptions($config['languages']);
    }
}
