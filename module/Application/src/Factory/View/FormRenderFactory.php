<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev
 * Date: 6/27/17
 * Time: 11:52 AM
 */
namespace Application\Factory\View;


use Application\Options\LanguageOptions;
use Application\View\Helper\FormRender;
use Interop\Container\ContainerInterface;
use Zend\ServiceManager\Factory\FactoryInterface;
use Zend\Cache\Storage\Adapter\Filesystem;

class FormRenderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $languageOption = $container->get(LanguageOptions::class);


        return new FormRender($languageOption);
    }
}