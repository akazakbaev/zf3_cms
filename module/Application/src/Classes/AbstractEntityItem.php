<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 4/5/18
 * Time: 8:57 AM
 */
namespace Application\Classes;

use User\Service\AuthManager;
use Application\Provider\ItemEntityInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

abstract class AbstractEntityItem implements ItemEntityInterface
{
    protected $identity;

    protected $itemType;

    protected $sm;


    public function setServiceLocator(ServiceLocatorInterface $sm)
    {
        $this->sm = $sm;
    }

    public function getServiceLocator()
    {
        return $this->sm;
    }

    public function getEm()
    {
        return $this->getServiceLocator()->get('doctrine.entitymanager.orm_default');
    }

    /**
     * @return AuthManager
     */
    public function getAuthManager()
    {
        return $this->getServiceLocator()->get(AuthManager::class);
    }

    public function getIdentity()
    {
        $meta = $this->getEm()->getClassMetadata(get_class($this));
        $identifier = $meta->getSingleIdentifierFieldName();

        $method = 'get'.ucfirst($identifier);

        if((new \ReflectionClass($this))->hasMethod($method))
        {
            $this->identity = $this->$method();
        }

        return $this->identity;
    }

    public function getItemType()
    {
        if($this->itemType === null)
        {
            $this->itemType = lcfirst((new \ReflectionClass($this))->getShortName());
        }

        return strtolower(trim(preg_replace('/([a-z0-9])([A-Z])/', '\1_\2', $this->itemType), '-. '));
    }

    public function getTitle()
    {
        return 'Unknown';
    }

    public function getHref()
    {
        return null;
    }

    public function __toString()
    {
        $href = $this->getHref();
        $title = $this->getTitle();

        $viewHelperManager = $this->sm->get('ViewHelperManager');

        $htmlLink = $viewHelperManager->get('htmlLink');

        if( !$href ) {
            return $title;
        } else if( !$htmlLink ) {
            return '<a href="'.$href.'">'.$title.'</a>';
        } else {
            return $htmlLink($href, $title, array());
        }
    }
}