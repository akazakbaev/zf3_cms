<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application;

use Application\Controller\Admin\IndexController as AdminIndexController;
use Application\Controller\Admin\TeamController as AdminTeamController;
use Application\Controller\Admin\SettingsController as AdminSettingsController;
use Application\Controller\Admin\ServicesController as AdminServicesController;
use Application\Controller\Admin\LanguagesController as AdminLanguagesController;
use Application\Controller\Admin\SlidersController as AdminSlidersController;
use Application\Controller\Plugin\Languages;
use Application\Factory\Controller\Admin\LanguagesControllerFactory as AdminLanguagesControllerFactory;
use Application\Factory\Controller\Admin\IndexControllerFactory as AdminIndexControllerFactory;
use Application\Factory\Controller\Admin\ServicesControllerFactory as AdminServicesControllerFactory;
use Application\Factory\Controller\Admin\SettingsControllerFactory as AdminSettingsControllerFactory;
use Application\Factory\Controller\Admin\SlidersControllerFactory as AdminSlidersControllerFactory;
use Application\Factory\Controller\ItemInvokableControllerFactory;
use Application\Factory\Controller\Plugin\LanguagesFactory;
use Application\Factory\Listener\RouteListenerFactory;
use Application\Factory\Options\LanguageOptionsFactory;
use Application\Factory\Service\CacheManagerFactory;
use Application\Factory\Service\DatabaseTranslationLoaderFactory;
use Application\Factory\Service\ItemManagerFactory;
use Application\Factory\Service\LangugeManagerFactory;
use Application\Factory\Service\SettingsManagerFactory;
use Application\Factory\Service\SliderManagerFactory;
use Application\Factory\View\FormRenderFactory;
use Application\Factory\View\ItemPhotoFactory;
use Application\Factory\View\LanguageSwitchFactory;
use Application\Factory\View\RenderWidgetFactory;
use Application\Factory\View\SettingsFactory;
use Application\Listener\RouteListener;
use Application\Service\ItemManager;
use Application\Service\SliderManager;
use Application\View\Helper\FormRender;
use Application\View\Helper\HtmlImage;
use Application\View\Helper\HtmlLink;
use Application\View\Helper\ItemPhoto;
use Application\View\Helper\LanguageSwitch;
use Application\View\Helper\RenderWidget;
use Application\View\Helper\Settings;
use Application\View\Helper\Truncate;
use Doctrine\ORM\Mapping\Driver\AnnotationDriver;
use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;
use Zend\ServiceManager\Factory\InvokableFactory;
use Zend\Router\Http\TreeRouteStack;

return [
    'router' => [
        'router_class'           => Mvc\Router\Http\LanguageTreeRouteStack::class,
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
                        'controller' => AdminSettingsController::class,
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
            'admin_services' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => ADMIN_PATH.'/services[/:action][/:id]',
                    'defaults' => [
                        'controller' => AdminServicesController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'admin_sliders' => [
                'type' => Segment::class,
                'options' => [
                    'route'    => ADMIN_PATH.'/sliders[/:action][/:id]',
                    'defaults' => [
                        'controller' => AdminSlidersController::class,
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
            AdminSettingsController::class => AdminSettingsControllerFactory::class,
            AdminLanguagesController::class => AdminLanguagesControllerFactory::class,
            AdminTeamController::class => ItemInvokableControllerFactory::class,
            AdminServicesController::class => AdminServicesControllerFactory::class,
            AdminSlidersController::class => AdminSlidersControllerFactory::class
        ],
    ],
    'controller_plugins' => [
        'factories' => [
            Languages::class => LanguagesFactory::class
        ],
        'aliases' => [
            'languages' => Languages::class,
        ]
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
            'admin/breadcrumbs'        => __DIR__ . '/../view/navigation/admin-breadcrumbs.phtml',
            'application/widgets/sliders'            => __DIR__ . '/../src/Widgets/Sliders/index.phtml',
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
            'htmlImage' => HtmlImage::class,
            'htmlLink' => HtmlLink::class,
            'formRowDefault' => \Application\View\Helper\FormRowDefault::class,
            'truncate' => Truncate::class,
        ],
        'factories' => [
            View\Helper\Breadcrumbs::class => InvokableFactory::class,
            FormRender::class => FormRenderFactory::class,
            LanguageSwitch::class => LanguageSwitchFactory::class,
            Settings::class => SettingsFactory::class,
            RenderWidget::class => RenderWidgetFactory::class,
            ItemPhoto::class => ItemPhotoFactory::class,
        ],
        'aliases' => [
            'formRender' => FormRender::class,
            'renderWidget' => RenderWidget::class,
            'itemPhoto' => ItemPhoto::class,
            'languageSwitch' => LanguageSwitch::class,
            'settings' => Settings::class
        ]
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
            Service\SettingsManager::class => SettingsManagerFactory::class,
            RouteListener::class => RouteListenerFactory::class,
            ItemManager::class => ItemManagerFactory::class,
            SliderManager::class => SliderManagerFactory::class
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
            'sliders' => [
                'label' => 'Sliders',
                'route' => 'admin_sliders',
                'order' => 4
            ],
            'admin_team' => [
                'label' => 'Team',
                'route' => 'admin_team',
                'order' => 2
            ],
            'admin_services' => [
                'label' => 'Services',
                'route' => 'admin_services',
                'order' => 3
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
