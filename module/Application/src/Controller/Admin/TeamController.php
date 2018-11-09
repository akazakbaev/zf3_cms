<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\Admin;

use Application\Classes\AdminController;
use Application\Form\Admin\Team;
use Zend\View\Model\ViewModel;

class TeamController extends AdminController
{
    public function indexAction()
    {
//        return [
//
//        ];
    }

    public function createAction()
    {
        $form = new Team('create');

        $request = $this->getRequest();

        if ($request->isPost())
        {
            $post = $request->getPost()->toArray();

            $form->setData($post);

            if (!$form->isValid($post))
            {
                $this->flashMessenger()->setNamespace('error')->addMessage('Invalid data');

                return array(
                    'form' => $form
                );
            }

            $values = $form->getData();

            if($this->languageManager->save($values))
            {
                return $this->redirect()->toRoute('languages', array('action' => 'index'));
            }
            else
            {
                $this->flashMessenger()->setNamespace('error')->addMessage('Word already added');

                return array(
                    'form' => $form
                );
            }
        }
        else
        {
            return [
                'form' => $form
            ];
        }
    }
}
