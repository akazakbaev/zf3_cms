<?php
/**
 * Created by PhpStorm.
 * User: RAVSHAN
 * Date: 24.02.14
 * Time: 23:54
 */

namespace User\Controller;

use User\Entity\UserUsers;
use User\Service\PermissionManager;
use User\Service\RbacManager;
use Zend\Authentication\AuthenticationService;
use Zend\Json\Json;
use Zend\Mvc\Controller\AbstractActionController;
use User\Model\User;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;
use Zend\View\Model\JsonModel;

class IndexController extends AbstractActionController
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \User\Service\UserManager
     */
    private  $userManager;

    public function __construct($entityManager, $userManager)
    {
        $this->entityManager = $entityManager;

        $this->userManager = $userManager;
    }

    public function indexAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('user.list', null)) return;

        $page = $this->params()->fromQuery('page', 1);

        $query = $this->userManager->getListQuery([]);

        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(10);
        $paginator->setCurrentPageNumber($page);

        return [
            'items' => $paginator
        ];
    }

    public function createAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('user.create', null)) return;

        $item = new UserUsers();
        $form = new \User\Form\Create('create', $this->entityManager, null);

        $permissionManager = $this->getEvent()->getApplication()->getServiceManager()->get(PermissionManager::class);

        $form->get('level_id')->setValueOptions($permissionManager->getLevelsList(true));

        $request = $this->getRequest();

        if ($request->isPost())
        {
            $post = array_merge_recursive(
                $request->getPost()->toArray(), $request->getFiles()->toArray()
            );

            $form->setData($post);

            if (!$form->isValid())
            {
                return array(
                    'form' => $form,
                    'item' => $item
                );
            }

            $values = $form->getData();

            $this->userManager->save($values);

            return $this->redirect()->toRoute('user_profile', ['id' => $item->getId()]);
        }
        else
        {
            return array(
                'form' => $form,
                'item' => $item
            );
        }
    }

    public function editAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('user.create', null)) return;

        $id = $this->params()->fromRoute('id', false);

        $item = $this->userManager->getUserById($id);

        if ($item == null)
        {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new \User\Form\Create('edit', $this->entityManager, $item);

        $permissionManager = $this->getEvent()->getApplication()->getServiceManager()->get(PermissionManager::class);

        $form->get('level_id')->setValueOptions($permissionManager->getLevelsList(true));

        $request = $this->getRequest();

        if ($request->isPost())
        {
            $post = array_merge_recursive(
                $request->getPost()->toArray(), $request->getFiles()->toArray()
            );

            $form->setData($post);

            if (!$form->isValid())
            {
                return array(
                    'form' => $form,
                    'item' => $item
                );
            }

            $values = $form->getData();

            $this->userManager->save($values, $item);

            return $this->redirect()->toRoute('user_profile', ['id' => $item->getId()]);
        }
        else
        {
            $values = $item->toArray();

            unset($values['password']);

            $form->populateValues($values);

            return array(
                'form' => $form,
                'item' => $item
            );
        }
    }

    public function deleteAction()
    {
        $id = $this->params()->fromPost('id', 0);

        $table = Api::_()->getDbtable('users', 'user');
        $item = $table->find($id);

        $jsonModel = new JsonModel();

        if (!$item || !$item->getIdentity()) {
            $jsonModel->setVariables(array('status' => false));

            return $jsonModel;
        }

        $levelTable = Api::_()->getDbtable('levels', 'authorization');

        $level = $levelTable->find($item->level_id);

        if(!$level)
        {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        if(!$this->requireAuth()->setAuthParams('admin_user_'.$level->type, null, 'delete')->isValid())
        {
            $jsonModel->setVariables(array('status' => false));

            return $jsonModel;
        }

        $db = $table->beginTransaction();

        try {

            $item->delete();

            $db->commit();
        } catch (\Exception $e) {
            $db->rollback();
            throw $e;
        }

        $jsonModel->setVariables(array('status' => true));

        return $jsonModel;
    }

    public function loginAction()
    {
        $id = $this->params()->fromRoute('id');

        /** @var AuthenticationService $authService */
        $authService = $this->getEvent()->getApplication()->getServiceManager()->get(AuthenticationService::class);

        $authService->getStorage()->write($id);
    }

    public function findUserAjaxAction()
    {
        $fullName = $this->request->getQuery()->get('search');
        $users = $this->entityManager->getRepository(UserUsers::class)->findUsersSelect2($fullName);
        return new JsonModel($users);
    }
} 