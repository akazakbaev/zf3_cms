<?php
namespace Application\Factory\Service;

use Application\Service\DatabaseTranslationLoader;
use Interop\Container\ContainerInterface;
use Application\Service\LanguageManager;

/**
 * This is the factory class for RbacManager service. The purpose of the factory
 * is to instantiate the service and pass it dependencies (inject dependencies).
 */
class LangugeManagerFactory
{
    /**
     * This method creates the RbacManager service and returns its instance. 
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $entityManager = $container->get('doctrine.entitymanager.orm_default');
        $languageOptions = $container->get(\Application\Options\LanguageOptions::class);
        $translateLoader = $container->get(DatabaseTranslationLoader::class);

        return new LanguageManager($entityManager, $languageOptions, $translateLoader);
    }
}

