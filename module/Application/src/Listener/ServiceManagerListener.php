<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 4/5/18
 * Time: 5:02 PM
 */
namespace Application\Listener;

use Zend\ServiceManager\ServiceManager;

class ServiceManagerListener
{
    private $sm;

    public function __construct(ServiceManager $sm)
    {
        $this->sm = $sm;
    }

    public function postLoad($eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $class = new \ReflectionClass($entity);

        if ($class->implementsInterface('Application\Provider\ItemEntityInterface'))
        {
            $entity->setServiceLocator($this->sm);
        }
    }

    /**
     * @param $eventArgs \Doctrine\ORM\Event\LifecycleEventArgs
     * @throws \ReflectionException
     */
    public function postPersist($eventArgs)
    {
        $entity = $eventArgs->getEntity();
        $class = new \ReflectionClass($entity);

        if ($class->implementsInterface('Application\Provider\ItemEntityInterface'))
        {
            $entity->setServiceLocator($this->sm);
        }
    }


}