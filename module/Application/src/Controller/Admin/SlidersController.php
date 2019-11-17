<?php

namespace Application\Controller\Admin;

use Application\Classes\AdminController;
use Application\Entity\ApplicationSliders;
use Application\Form\Admin\Services;
use Application\Form\Admin\Sliders;
use Application\Service\SliderManager;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\JsonModel;
use Zend\View\Model\ViewModel;

class SlidersController extends AdminController
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var SliderManager
     */
    private $sliderManager;

    public function __construct(EntityManager $entityManager, SliderManager $sliderManager)
    {
        $this->entityManager = $entityManager;

        $this->sliderManager = $sliderManager;
    }

    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);

        $paginator = $this->entityManager->getRepository(ApplicationSliders::class)->getItems(['page' => $page]);

        return [
            'items' => $paginator
        ];
    }

    public function createAction()
    {
        $form = new Sliders('create', $this->entityManager, $this->languages());

        $item = new ApplicationSliders();

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
                if($this->sliderManager->save($item, $post))
                    $this->redirect()->toRoute('admin_sliders');
            }
        }

        return [
            'form' => $form
        ];
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id', false);

        $item = $this->entityManager->getRepository(ApplicationSliders::class)->find($id);

        if ($item == null)
        {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new Sliders('edit', $this->entityManager, $this->languages());

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
                if($this->sliderManager->save($item, $post))
                    $this->redirect()->toRoute('admin_sliders');
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

        $item = $this->entityManager->getRepository(ApplicationSliders::class)->find($id);

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
