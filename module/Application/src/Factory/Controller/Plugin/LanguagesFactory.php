<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev
 * Date: 5/15/17
 * Time: 3:51 PM
 */
namespace Application\Factory\Controller\Plugin;


use Application\Controller\Plugin\Languages;
use Application\Options\LanguageOptions;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;

class LanguagesFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $languageOptions = $container->get(LanguageOptions::class);

        return new Languages($languageOptions);
    }
}