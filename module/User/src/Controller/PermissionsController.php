<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 1/31/18
 * Time: 10:06 AM
 */
namespace User\Controller;

use User\Form\Permissions;
use Zend\Mvc\Controller\AbstractActionController;

class PermissionsController extends AbstractActionController
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \User\Service\PermissionManager
     */
    private  $permissionManager;

    public function __construct($entityManager, $permissionManager)
    {
        $this->entityManager = $entityManager;

        $this->permissionManager = $permissionManager;
    }

    public function indexAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('settings.permissions', null)) return;

        $level_id = $this->params()->fromQuery('level_id', 1);

        $form = new Permissions('create');

        $levels = $this->permissionManager->getLevelsList();

        $form->get('level_id')->setValueOptions($levels);
        $form->get('level_id')->setValue($level_id);

        $level = $this->permissionManager->getLevel($level_id);

        $permissions = $this->permissionManager->preparePermissionOptions($level);

        $form->get('permissions')->setValueOptions($permissions);

        $request = $this->getRequest();

        if (!$request->isPost())
        {
            return [
                'form' => $form
            ];
        }

        $post = $request->getPost()->toArray();
        $form->setData($post);

        if (!$form->isValid())
        {
            return [
                'form' => $form,
            ];
        }

        $values = $form->getData();

        $this->permissionManager->save($values);

        return $this->redirect()->toRoute('permissions', [], ['query' => ['level_id' => $level_id]]);
    }
}