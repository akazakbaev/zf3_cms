<?php
namespace Application\Factory\View;

use Application\Service\FileManager;
use Application\View\Helper\RenderWidget;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class RenderWidgetFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $options = [
            'route' => $container->get('Router'),
            'application' => $container->get('Application'),
            'entityManager' => $container->get('doctrine.entitymanager.orm_default')
        ];

        return new RenderWidget($options);
    }
}
