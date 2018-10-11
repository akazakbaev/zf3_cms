<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace User;


use User\Factory\Controller\IndexControllerFactory;
use User\Factory\Controller\Admin\PermissionsControllerFactory;
use User\Factory\Controller\ProfileControllerFactory;
use User\Factory\View\ViewerFactory;
use User\View\Helper\Viewer;
use Zend\Form\Factory;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

return [
    'router' => [
        'routes' => [
            'login' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => ADMIN_PATH . '/login',
                    'defaults' => [
                        'controller' => Controller\Admin\AuthController::class,
                        'action'     => 'login',
                    ],
                ],
            ],
            'logout' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => ADMIN_PATH . '/logout',
                    'defaults' => [
                        'controller' => Controller\Admin\AuthController::class,
                        'action'     => 'logout',
                    ],
                ],
            ],

            'user_profile' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/profile/[:id][/]',
                    'defaults' => [
                        'controller' => Controller\ProfileController::class,
                        'action'     => 'index',
                    ],
                    'constraints' => [
                        'id' => '[0-9]*'
                    ],
                ],
            ],
            'admin_permissions' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => ADMIN_PATH .'/permission[/:action]',
                    'defaults' => [
                        'controller' => Controller\Admin\PermissionsController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'user_general' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/user[/:action][/:id]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                    'constraints' => [
                        'id' => '[0-9]*'
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\Admin\AuthController::class => \User\Factory\Controller\Admin\AuthControllerFactory::class,
            Controller\IndexController::class => IndexControllerFactory::class,
            Controller\Admin\PermissionsController::class => PermissionsControllerFactory::class,
            Controller\ProfileController::class => ProfileControllerFactory::class,
        ],
    ],

    'service_manager' => [
        'factories' => [
            \Zend\Authentication\AuthenticationService::class => \User\Factory\Service\AuthenticationServiceFactory::class,
            Service\AuthAdapter::class => \User\Factory\Service\AuthAdapterFactory::class,
            Service\AuthManager::class => \User\Factory\Service\AuthManagerFactory::class,
            Service\UserManager::class => \User\Factory\Service\UserManagerFactory::class,
            Strategy\DenyStrategy::class      => \User\Factory\Strategy\DenyStrategyFactory::class,
            Service\RbacManager::class => \User\Factory\Service\RbacManagerFactory::class,
            Service\PermissionManager::class => \User\Factory\Service\PermissionManagerFactory::class,
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            Controller\Plugin\RequireUser::class => \User\Factory\Controller\Plugin\RequireUserFactory::class,
            Controller\Plugin\RequireAccess::class => \User\Factory\Controller\Plugin\RequireAccessFactory::class,
            Controller\Plugin\Viewer::class => \User\Factory\Controller\Plugin\ViewerFactory::class,
        ],
        'aliases' => [
            'requireUser' => Controller\Plugin\RequireUser::class,
            'requireAccess' => Controller\Plugin\RequireAccess::class,
            'viewer' => Controller\Plugin\Viewer::class
        ],
    ],
    'view_manager' => [
        'deny_template'       => 'error/403',
        'template_map' => [
            'error/403'               => __DIR__ . '/../view/error/403.phtml',
            'error/401'               => __DIR__ . '/../view/error/401.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'template_map' => [
            'user/widgets/profile-info' => __DIR__ . '/../src/Widgets/ProfileInfo/index.phtml',
        ]
    ],
    'view_helpers' => [
        'factories' => [
            Viewer::class => ViewerFactory::class,
        ],
        'aliases' => [
            'viewer' => Viewer::class,
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
        'default' => [

        ],
    ]
];
