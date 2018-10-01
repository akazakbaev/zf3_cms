<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/12/18
 * Time: 6:55 PM
 */
namespace User\Controller\Plugin;

use User\Entity\UserUsers;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

class RequireUser extends AbstractPlugin
{
    /**
     * Auth manager.
     * @var \User\Service\AuthManager
     */
    private $authManager;

    private $response;

    public function __construct($authManager, $response)
    {
        $this->authManager = $authManager;
        $this->response = $response;
    }

    public function __invoke()
    {
        try
        {
            $viewer = $this->authManager->getViewer();
        }
        catch (\Exception $e)
        {
            var_dump($e->getMessage());die;
            $viewer = null;
        }

        $ret = false;

        if( $viewer instanceof UserUsers && $viewer->getUserId() )
        {
            $ret = true;
        }
        else
        {
            $this->response->setStatusCode(401);
        }

        return $ret;
    }
}