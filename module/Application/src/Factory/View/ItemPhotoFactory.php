<?php
namespace Application\Factory\View;

use Storage\Service\FileManager;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Application\View\Helper\ItemPhoto;

class ItemPhotoFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $fileManager = $container->get(FileManager::class);

        return new ItemPhoto($fileManager);
    }
}
