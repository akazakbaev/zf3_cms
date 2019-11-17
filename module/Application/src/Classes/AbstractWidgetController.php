<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/22/18
 * Time: 12:06 PM
 */
namespace Application\Classes;


abstract class AbstractWidgetController
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    public $entityManager;

    /**
     * @var \User\Service\AuthManager;
     */
    public $authManager;

    /**
     * @var \Zend\Mvc\Application
     */
    public $application;
    /**
     * Constructs the service.
     */
    public function __construct(array $options)
    {
        foreach( $options as $key => $value )
        {
            if( property_exists($this, $key) )
            {
                $this->$key = $value;
            }
        }
    }
}