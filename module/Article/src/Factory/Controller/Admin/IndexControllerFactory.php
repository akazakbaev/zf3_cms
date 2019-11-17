<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/12/18
 * Time: 3:22 PM
 */
namespace Article\Factory\Controller\Admin;

use Article\Service\ArticleManager;
use Interop\Container\ContainerInterface;
use Article\Controller\Admin\IndexController;
use Zend\ServiceManager\Factory\FactoryInterface;

/**
 * This is the factory for UserController. Its purpose is to instantiate the
 * controller and inject dependencies into it.
 */
class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $articleManager = $container->get(ArticleManager::class);

        return new $requestedName($entityManager, $articleManager);
    }
}