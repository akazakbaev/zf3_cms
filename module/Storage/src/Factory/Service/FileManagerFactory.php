<?php
namespace Storage\Factory\Service;

use Storage\Entity\StorageServices;
use Storage\Exception\StoreException;
use Storage\Service\FileManager;
use Interop\Container\ContainerInterface;
use User\Service\AuthManager;

/**
 * This is the factory class for RbacManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class FileManagerFactory
{
    private $entityManager;
    /**
     * This method creates the RbacManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $this->entityManager = $entityManager = $container->get('doctrine.entitymanager.orm_default');

        $authManager = $container->get(AuthManager::class);
        
        $config = $container->get('Config');

        if(isset($config['storage']) && isset($config['storage']['service_id']))
        {
            $storageService = $this->entityManager->getRepository(StorageServices::class)->find($config['storage']['service_id']);
        }
        else
        {
            $storageService = $this->getDefaultService();
        }

        return new FileManager($entityManager, $authManager, $storageService);
    }

    private function getDefaultService()
    {
        $service = $this->entityManager->getRepository(StorageServices::class)
            ->findOneBy(['default' => 1]);

        if( !$service ) {
            throw new StoreException('Unable to find default storage service');
        }


        return $service;
    }
}

