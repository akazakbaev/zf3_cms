<?php
/**
 * Created by JetBrains PhpStorm.
 * User: azim
 * Date: 9/19/13
 * Time: 5:09 PM
 * To change this template use File | Settings | File Templates.
 */

namespace User\View\Helper;

use Zend\View\Helper\AbstractHelper;


class Viewer extends AbstractHelper
{
    /**
     * Auth service.
     * @var \User\Service\AuthManager
     */
    private $authManager;

    public function __construct($authManager)
    {
        $this->authManager = $authManager;
    }
    /**
     *
     * @return \User\Entity\UserUsers
     */

    public function __invoke()
    {

        return $this->authManager->getViewer();
    }
}