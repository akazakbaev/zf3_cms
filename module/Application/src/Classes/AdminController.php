<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 4/6/18
 * Time: 12:51 PM
 */
namespace Application\Classes;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\Mvc\MvcEvent;

/**
 * Class ActionController
 * @method \User\Controller\Plugin\Viewer viewer()
 * @method \User\Controller\Plugin\RequireUser requireUser()
 * @method \User\Controller\Plugin\RequireAccess requireAccess()
 * @package Application\Classes
 */
class AdminController extends AbstractActionController
{
    public function onDispatch(MvcEvent $e)
    {
        $this->layout()->setTemplate('layout/admin');

        if(!$this->requireUser()) return;

        return parent::onDispatch($e);
    }
}