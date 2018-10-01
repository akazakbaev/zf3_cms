<?php
/**
 * Created by PhpStorm.
 * User: RAVSHAN
 * Date: 24.02.14
 * Time: 23:54
 */

namespace User\Controller;


use User\Entity\UserUsers;
use User\Service\AuthManager;
use User\Service\UserManager;
use Zend\Session\Container;
use Zend\View\Model\ViewModel;
use Zend\Mvc\MvcEvent;
use Zend\Mvc\Controller\AbstractActionController;
use Zf\Infocom\Core\Exception\HrmAuthIdException;
use Zf\Infocom\Core\Service\HrmAuthIdManager;

class AuthController extends AbstractActionController
{
    /**
     * Auth manager.
     * @var \User\Service\AuthManager
     */
    private $authManager;

    /**
     * User manager.
     * @var \User\Service\UserManager
     */
    private $userManager;

    /**
     * Constructor.
     */
    public function __construct(AuthManager $authManager, UserManager $userManager)
    {
        $this->authManager = $authManager;
        $this->userManager = $userManager;
    }


    public function loginAction()
    {
        $this->layout()->setTemplate('layout/login');

        $viewer = $this->authManager->getViewer();

        if ($viewer && $viewer->getUserId())
        {
            return $this->redirect()->toRoute('home');
        }

        $viewModel = new ViewModel();

        $form = new \User\Form\Login();

        $viewModel->setVariable('form', $form);

        if (!$this->getRequest()->isPost())
        {
            $form->get('return_url')->setValue($this->params()->fromQuery('return', @$_SERVER['HTTP_REFERER']));

            return $viewModel;
        }

        $form->setData($this->getRequest()->getPost());

        if (!$form->isValid())
        {
            return [
                'form' => $form
            ];
        }

        $email = $this->params()->fromPost('email');
        $password = $this->params()->fromPost('password');
        $return_url = $this->params()->fromPost('return_url');


        $authResult = $this->authManager->login($email, $password, false);

        if (!$authResult->isValid())
        {
            foreach ($authResult->getMessages() as $message)
            {
                $this->flashMessenger()->setNamespace('error')->addMessage($this->translator()->translate($message));
            }

            return [
                'form' => $form
            ];
        }

        if($return_url != '')
        {
            return $this->redirect()->toUrl($return_url);
        }

        return $this->redirect()->toRoute('home', array());
    }

    public function logoutAction()
    {
        // Check if already logged out
        $viewer = $this->authManager->getViewer();

        if (!$viewer->getUserId())
        {
            return $this->redirect()->toRoute('login');
        }

        $this->authManager->logout();

        return $this->redirect()->toRoute('home');
    }
} 