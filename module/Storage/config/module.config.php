<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Storage;


use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Storage\Factory\Service\FileManagerFactory;
use Storage\Factory\Storage\LocalFactory;

return [
    'router' => [
        'routes' => [
        ],
    ],
    'controllers' => [
        'factories' => [

        ]
    ],
    'service_manager' => [
        'factories' => [
            Service\FileManager::class => FileManagerFactory::class,
            Storage\Local::class => LocalFactory::class
        ],
    ],
    'view_helpers' => [
        'factories' => [
        ],
        'aliases' => [
        ],
        'invokables' => [

        ]
    ],
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [__DIR__ . '/../src/Entity']
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                ]
            ]
        ]
    ],
];
