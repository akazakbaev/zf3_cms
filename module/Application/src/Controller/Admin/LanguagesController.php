<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 1/31/18
 * Time: 10:06 AM
 */
namespace Application\Controller\Admin;

use Application\Classes\AdminController;
use Application\Form\Language\CreatePhrase;
use Application\Options\LanguageOptions;
use Zend\View\Model\JsonModel;

use Zend\Mvc\Controller\AbstractActionController;

use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator;

class LanguagesController extends AdminController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * Post manager.
     * @var \Application\Service\LanguageManager
     */
    private $languageManager;

    public function __construct($entityManager, $languageManager)
    {
        $this->entityManager = $entityManager;
        $this->languageManager = $languageManager;

    }

    public function indexAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('languages.list', null)) return;

        $page = $this->params()->fromQuery('page', 1);
        $query = $this->params()->fromQuery('query');

        $select = $this->languageManager->getListQuery(['query' => $query]);

        $adapter = new DoctrineAdapter(new ORMPaginator($select, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage(20);
        $paginator->setCurrentPageNumber($page);

        return [
          'items' => $paginator,
            'query' => $query
        ];
    }

    public function createAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('languages.create', null)) return;

        $languageOptions = $this->getEvent()->getApplication()->getServiceManager()->get(LanguageOptions::class);

        $form = new CreatePhrase('create', $languageOptions);

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

    public function editAction()
    {
        if(!$this->requireUser()) return;
        if(!$this->requireAccess('languages.create', null)) return;

        $id = $this->params()->fromRoute('id', false);

        $item = $this->languageManager->getItemById($id);

        if ($item == null)
        {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        $languageOptions = $this->getEvent()->getApplication()->getServiceManager()->get(LanguageOptions::class);

        $form = new CreatePhrase('edit', $languageOptions);

        $form->get('key')->setAttribute('readonly', true);

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

            $this->languageManager->save($values, $item);

            return $this->redirect()->toRoute('languages', array('action' => 'index'));
        }
        else
        {
            $values = [
                'key' => $item->getKey(),
                'js' => $item->getJs()
            ];

            $translates = $item->getTranslates();

            foreach ($translates as $translate)
            {
                $values[$translate->getLocale()] = $translate->getTranslate();
            }

            $form->populateValues($values);

            return [
                'form' => $form
            ];
        }
    }


    public function jsonAction()
    {
        $jsonModel = new JsonModel();

        $data = [];

        $listQuery = $this->languageManager->getListQuery(['js' => 1]);

        foreach ($listQuery->getResult() as $item)
        {
            $translates = $item->getTranslates();

            foreach ($translates as $translate)
            {
                $data[$item->getKey()][\Locale::getPrimaryLanguage($translate->getLocale())] = $translate->getTranslate();
            }
        }

        $jsonModel->setVariables(array('data' => $data));

        return $jsonModel;
    }
}