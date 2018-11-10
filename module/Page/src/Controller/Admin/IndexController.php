<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Page\Controller\Admin;

use Application\Classes\AdminController;
use Application\Options\LanguageOptions;
use Page\Entity\PagePages;
use Page\Form\Create;
use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AdminController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);

        $paginator = $this->entityManager->getRepository(PagePages::class)->getItems(['page' => $page]);

        return [
            'items' => $paginator
        ];
    }

    public function createAction()
    {
        $languageOptions = $this->getEvent()->getApplication()->getServiceManager()->get(LanguageOptions::class);
        $form = new Create('create', $this->entityManager, $languageOptions);

        return [
            'form' => $form
        ];
    }

    public function editAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('user.list', null)) return;

        $id = $this->params()->fromRoute('id', false);

        $item = $this->entityManager->getRepository(PagePages::class)->find($id);

        $form = new Create('edit', $this->entityManager);

        $form->bind($item);

        if ($this->request->isPost())
        {
            $form->setData($this->request->getPost());

            if ($form->isValid())
            {
                $conn = $this->entityManager->getConnection();
                $conn->beginTransaction();
                try{
                    $this->entityManager->persist($item);
                    $this->entityManager->flush();

                    $this->entityManager->getConnection()->commit();

                    $this->redirect()->toRoute('pages_general');
                }
                catch(\Exception $e)
                {
                    $this->entityManager->getConnection()->rollBack();

                    $this->flashMessenger()->setNamespace('error')->addMessage($e->getMessage());
                }
            }
        }

        return [
            'form' => $form
        ];
    }

}
