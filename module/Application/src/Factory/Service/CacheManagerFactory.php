<?php
namespace Application\Factory\Service;

use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Cache\Storage\Adapter\Filesystem;
use Application\Service\CacheManager;

class CacheManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');

        $settings = $config['cacheSettings'] ??  [
                'adapter' => [
                    'name'    => Filesystem::class,
                    'options' => [
                        // Store cached data in this directory.
                        'cache_dir' => './data/cache',
                        // Store cached data for 24 hour.
                        'ttl' => 60*60*24,
                        'file_permission' => '0666',
                        'dir_permission' => '0777'
                    ],
                ],
                'plugins' => [
                    [
                        'name' => 'serializer',
                        'options' => [
                        ],
                    ],
                ],
            ];

        return new CacheManager($settings);
    }
}

