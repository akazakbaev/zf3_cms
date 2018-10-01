<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/12/18
 * Time: 6:55 PM
 */
namespace User\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zf\Infocom\Core\Classes\AbstractEntityItem;

/**
 * Class Viewer
 * @package User\Controller\Plugin
 */
class Viewer extends AbstractPlugin
{
    /**
     * Auth manager.
     * @var \User\Service\AuthManager
     */
    private $authManager;

    public function __construct($authManager)
    {
        $this->authManager = $authManager;
    }

    /**
     * @return AbstractEntityItem
     */
    public function __invoke()
    {
        return $this->authManager->getViewer();
    }
}