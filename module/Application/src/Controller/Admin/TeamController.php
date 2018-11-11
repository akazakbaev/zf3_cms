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
use Zend\View\Model\ViewModel;

class TeamController extends AdminController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    private $languageOptions;

    public function __construct($entityManager, $languageOptions)
    {
        $this->entityManager = $entityManager;

        $this->languageOptions = $languageOptions;
    }

    public function indexAction()
    {

        return [

        ];
    }

    public function createAction()
    {
        $form = new Team('create', $this->entityManager, $this->languageOptions);

        $request = $this->getRequest();

        $item = new ApplicationTeams();

        $form->bind($item);

        if ($request->isPost())
        {
            $post = $request->getPost()->toArray();

            $form->setData($post);

            if (!$form->isValid())
            {
                $this->flashMessenger()->setNamespace('error')->addMessage('Invalid data');

                return array(
                    'form' => $form
                );
            }

            $conn = $this->entityManager->getConnection();
            $conn->beginTransaction();
            try{

                $this->entityManager->persist($item);
                $this->entityManager->flush();

                $this->entityManager->getConnection()->commit();

                $this->redirect()->toRoute('admin_team');
            }
            catch(\Exception $e)
            {
                $this->entityManager->getConnection()->rollBack();

                $this->flashMessenger()->setNamespace('error')->addMessage($e->getMessage());
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
