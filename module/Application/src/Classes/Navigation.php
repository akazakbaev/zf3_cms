<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 8/26/18
 * Time: 3:06 PM
 */
namespace Application\Classes;

use Zend\Navigation\Service\AbstractNavigationFactory;
use Zend\Navigation\Exception;
use User\Service\RbacManager;
use Interop\Container\ContainerInterface;

class Navigation extends AbstractNavigationFactory
{

    /**
     * Filesystem cache.
     * @var \User\Service\RbacManager
     */
    private $rbacManager;

    protected function getName()
    {
        return 'default';
    }

    public function getPages(ContainerInterface $container)
    {

        $this->rbacManager = $container->get(RbacManager::class);

        if (null === $this->pages)
        {
            $configuration = $container->get('config');

            if (! isset($configuration['navigation'])) {
                throw new Exception\InvalidArgumentException('Could not find navigation configuration key');
            }
            if (! isset($configuration['navigation'][$this->getName()])) {
                throw new Exception\InvalidArgumentException(sprintf(
                    'Failed to find a navigation container by the name "%s"',
                    $this->getName()
                ));
            }

            $conf = $configuration['navigation'][$this->getName()];

            $application = $container->get('Application');

            $request     = $application->getMvcEvent()->getRequest();

            $pages       = $this->getPagesFromConfig($conf);

            foreach ($pages as $k => $v)
            {
                if(isset($v['pages']))
                {
                    $z = 0;
                    foreach ($v['pages'] as $j => $i)
                    {
                        if(isset($i['permission']))
                        {
                            if(!$this->checkPermission($i['permission']))
                            {
                                $z++;
                                unset($pages[$k]['pages'][$j]);
                            }
                        }
                    }

                    if(count($v['pages']) == $z)
                        unset($pages[$k]);
                }
                else
                {
                    if(isset($v['permission']))
                    {
                        if(!$this->checkPermission($v['permission']))
                        {
                            unset($pages[$k]);
                        }
                    }
                }
            }

            $this->pages = $this->preparePages($container, $pages);
        }
        return $this->pages;
    }

    public function checkPermission($permission)
    {
        return $this->rbacManager->isGranted(null, $permission);
    }
}