<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/14/18
 * Time: 12:37 PM
 */
namespace User\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * This controller plugin is used for role-based access control (RBAC).
 */
class RequireAccess extends AbstractPlugin
{
    /**
     * Filesystem cache.
     * @var \User\Service\RbacManager
     */
    private $rbacManager;

    private $response;

    public function __construct($rbacManager, $response)
    {
        $this->rbacManager = $rbacManager;

        $this->response = $response;
    }

    /**
     * Checks whether the currently logged in user has the given permission.
     * @param string $permission Permission name.
     * @param array $params Optional params (used only if an assertion is associated with permission).
     */
    public function __invoke($permission, $params = [])
    {
        $ret = $this->rbacManager->isGranted(null, $permission, $params);

        if($ret === false)
        {
            $this->response->setStatusCode(403);

            return false;
        }

        return true;
    }
}
