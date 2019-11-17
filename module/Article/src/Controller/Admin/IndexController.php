<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Article\Controller\Admin;

use Application\Classes\AdminController;
use Article\Service\ArticleManager;
use Article\Entity\ArticleArticles;
use Application\Options\LanguageOptions;
use Article\Form\Create;
use Doctrine\ORM\EntityManager;
use Zend\View\Model\JsonModel;

class IndexController extends AdminController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var ArticleManager
     */
    private $articleManager;

    public function __construct(EntityManager $entityManager, ArticleManager $articleManager)
    {
        $this->entityManager = $entityManager;

        $this->articleManager = $articleManager;
    }

    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);

        $paginator = $this->entityManager->getRepository(ArticleArticles::class)->getItems(['page' => $page]);

        return [
            'items' => $paginator
        ];
    }

    public function createAction()
    {
        $form = new Create('create', $this->entityManager, $this->languages());

        $item = new ArticleArticles();

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
                if($this->articleManager->save($item, $post))
                {
                    $this->redirect()->toRoute('admin_articles');
                }
            }
        }

        return [
            'form' => $form
        ];
    }

    public function editAction()
    {
        $id = $this->params()->fromRoute('id', false);

        $item = $this->entityManager->getRepository(ArticleArticles::class)->find($id);

        if ($item == null)
        {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $form = new Create('edit', $this->entityManager, $this->languages());

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
                if($this->articleManager->save($item, $post))
                {
                    $this->redirect()->toRoute('admin_articles');
                }
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

        $item = $this->entityManager->getRepository(ArticleArticles::class)->find($id);

        $this->entityManager->remove($item);

        $this->entityManager->flush();

        $jsonModel->setVariables(array('status' => true, 'reload' => true));

        return $jsonModel;
    }
}
