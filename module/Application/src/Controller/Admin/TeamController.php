<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller\Admin;

use Application\Classes\AdminController;
use Application\Entity\ApplicationTeams;
use Application\Form\Admin\Team;
use Application\Service\ItemManager;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class TeamController extends AdminController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $itemManager;

    public function __construct(EntityManager $entityManager, ItemManager $itemManager)
    {
        $this->entityManager = $entityManager;

        $this->itemManager = $itemManager;
    }

    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);

        $paginator = $this->entityManager->getRepository(ApplicationTeams::class)->getItems(['page' => $page]);

        return [
            'items' => $paginator
        ];
    }

    public function createAction()
    {
        $form = new Team('create', $this->entityManager, $this->languages());

        $item = new ApplicationTeams();

        $form->bind($item);

        $request = $this->getRequest();

        if ($this->request->isPost())
        {
            $post = array_merge_recursive(
                $request->getPost()->toArray(), $request->getFiles()->toArray()
            );

            $form->setData($post);

            if ($form->isValid())
            {
                if($this->itemManager->save($item, $post))
                    $this->redirect()->toRoute('admin_team');
            }
        }

        return [
            'form' => $form
        ];
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id', false);

        $item = $this->entityManager->getRepository(ApplicationTeams::class)->find($id);

        $form = new Team('edit', $this->entityManager, $this->languages());

        $form->bind($item);

        $request = $this->getRequest();

        if ($request->isPost())
        {
            $post = array_merge_recursive(
                $request->getPost()->toArray(), $request->getFiles()->toArray()
            );

            $form->setData($post);

            if ($form->isValid())
            {
                if($this->itemManager->save($item, $post))
                    $this->redirect()->toRoute('admin_team');
            }
        }

        return [
            'form' => $form
        ];
    }

    public function deleteAction()
    {
        $jsonModel = new JsonModel();

        if (!$this->requireUser())
        {
            $jsonModel->setVariables(array('status' => false));

            return $jsonModel;
        }

        $id = $this->params()->fromRoute('id', false);

        $item = $this->entityManager->getRepository(ApplicationTeams::class)->find($id);

        if (!$item)
        {
            $jsonModel->setVariables(array('status' => false));

            return $jsonModel;
        }

        $this->entityManager->remove($item);

        $this->entityManager->flush();

        $jsonModel->setVariables(array('status' => true, 'reload' => true));

        return $jsonModel;
    }
}
