<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Article;


use Article\Controller\IndexController;
use Article\Factory\Service\ArticleManagerFactory;
use Zend\Router\Http\Segment;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Article\Controller\Admin\IndexController as AdminIndexController;
use Article\Factory\Controller\Admin\IndexControllerFactory as AdminIndexControllerFactory;

return [
    'router' => [
        'routes' => [
            'articles_general' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => '/articles[/:action][/:id][/]',
                    'defaults' => [
                        'controller' => IndexController::class,
                        'action' => 'index'
                    ],
                    'constraints' => [
                        'id' => '[0-9]*',
                    ]
                ]
            ],

            'admin_articles' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => ADMIN_PATH .'/articles[/:action][/:id][/]',
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
            AdminIndexController::class => AdminIndexControllerFactory::class,
            IndexController::class => AdminIndexControllerFactory::class
        ]
    ],
    'service_manager' => [
        'factories' => [
            Service\ArticleManager::class => ArticleManagerFactory::class
        ],
    ],

    'view_manager' => [
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map' => [
            'article/widgets/newest-articles'            => __DIR__ . '/../src/Widgets/NewestArticles/index.phtml',
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
            'articles' => [
                'label' => 'Articles',
                'route' => 'admin_articles',
                'order' => 2
            ]
        ],
    ]
];
