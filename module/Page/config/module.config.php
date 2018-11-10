<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Page;


use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Page\Controller\Admin\IndexController as AdminIndexController;
use Page\Factory\Controller\Admin\IndexControllerFactory as AdminIndexControllerFactory;

return [
    'router' => [
        'routes' => [
            'admin_pages' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => ADMIN_PATH .'/pages[/:action][/]',
                    'defaults' => [
                        'controller' => AdminIndexController::class,
                        'action' => 'index'
                    ],
                    'constraints' => [
                        'id' => '[0-9]*',
                    ]
                ]
            ],
        ]
    ],
    'controllers' => [
        'factories' => [
            AdminIndexController::class => AdminIndexControllerFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [

        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map' => [
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
    'navigation' => [
        'admin' => [
            'pages' => [
                'label' => 'Pages',
                'route' => 'admin_pages',
                'order' => 2
            ]
        ],
    ]
];
