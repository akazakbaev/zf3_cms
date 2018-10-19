<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\Admin;

use Application\Classes\AdminController;
use Zend\View\Model\ViewModel;

class TeamController extends AdminController
{
    public function indexAction()
    {
        return new ViewModel();
    }

    public function createAction()
    {

    }
}
