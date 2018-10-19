<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\Admin\IndexController as AdminIndexController;
use Application\Controller\Admin\TeamController as AdminTeamController;
use Application\Factory\Controller\Admin\TeamControllerFactory as AdminTeamControllerFactory;
use Application\Controller\Admin\LanguagesController as AdminLanguagesController;
use Application\Factory\Controller\Admin\LanguagesControllerFactory as AdminLanguagesControllerFactory;
use Application\Factory\Controller\Admin\IndexControllerFactory as AdminIndexControllerFactory;
use Application\Factory\Options\LanguageOptionsFactory;
use Application\Factory\Service\CacheManagerFactory;
use Application\Factory\Service\DatabaseTranslationLoaderFactory;
use Application\Factory\Service\LangugeManagerFactory;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;

return [
    'router' => [
        'routes' => [
            'home' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'contacts' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/contacts',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'contacts',
                    ],
                ],
            ],
            'admin_home' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => ADMIN_PATH.'[/]',
                    'defaults' => [
                        'controller' => AdminIndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'admin_settings' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => ADMIN_PATH.'/settings[/:action]',
                    'defaults' => [
                        'controller' => Controller\SettingsController::class,
                        'action'     => 'general',
                    ],
                ],
            ],
            'admin_languages' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => ADMIN_PATH.'/languages[/:action][/:id]',
                    'defaults' => [
                        'controller' => AdminLanguagesController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'admin_team' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => ADMIN_PATH.'/team[/:action][/:id]',
                    'defaults' => [
                        'controller' => AdminTeamController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
            AdminIndexController::class => AdminIndexControllerFactory::class,
            Controller\SettingsController::class => \Application\Factory\Controller\SettingsControllerFactory::class,
            AdminLanguagesController::class => AdminLanguagesControllerFactory::class,
            AdminTeamController::class => AdminTeamControllerFactory::class
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'layout/admin'           => __DIR__ . '/../view/layout/admin.phtml',
            'layout/login'           => __DIR__ . '/../view/layout/login.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy'
        ]
    ],
    'view_helpers' => [
        'invokables' => [
            'translate' => \Zend\I18n\View\Helper\Translate::class,
            'pageBreadcrumbs' => View\Helper\Breadcrumbs::class,
            'formRender' => \Application\View\Helper\FormRender::class,
            'formRowDefault' => \Application\View\Helper\FormRowDefault::class,
        ],
        'factories' => [
            View\Helper\Breadcrumbs::class => InvokableFactory::class,
        ],
    ],
    'service_manager' => [
        'aliases' => [

        ],
        'factories' => [
            'main_navigation' => \Application\Factory\Service\MainNavigationFactory::class,
            'admin_navigation' => \Application\Factory\Service\AdminNavigationFactory::class,
            Service\CacheManager::class => CacheManagerFactory::class,
            Service\LanguageManager::class => LangugeManagerFactory::class,
            Options\LanguageOptions::class => LanguageOptionsFactory::class,
            Service\DatabaseTranslationLoader::class => DatabaseTranslationLoaderFactory::class,
        ],
        'delegators' => [
            'HttpRouter' => [ \Application\Factory\Mvc\Router\Http\LanguageTreeRouteStackDelegatorFactory::class ],
            TreeRouteStack::class => [ \Application\Factory\Mvc\Router\Http\LanguageTreeRouteStackDelegatorFactory::class ],
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
            'home' => [
                'label' => 'Home',
                'route' => 'home',
                'order' => 1
            ],
            'admin_team' => [
                'label' => 'Team',
                'route' => 'admin_team',
                'order' => 2
            ],
        ],
        'default' => [
            'home' => [
                'label' => 'Home',
                'route' => 'home',
                'order' => 1
            ]
        ],
    ]
];
