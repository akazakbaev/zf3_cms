<?php
/**
 * Created by PhpStorm.
 * User: RAVSHAN
 * Date: 24.02.14
 * Time: 23:54
 */

namespace User\Controller;

use Reserve\Classes\SearchData;
use Reserve\Entity\Repository\ReserveSelectionRepository;
use Reserve\Entity\ReserveSelection;
use User\Entity\UserUsers;
use Zend\Mvc\Controller\AbstractActionController;

class ProfileController extends AbstractActionController
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \User\Service\UserManager
     */
    private $userManager;

    /**
     * @var \User\Service\AuthManager
     */
    private $authManager;

    public function __construct($entityManager, $userManager, $authManager)
    {
        $this->entityManager = $entityManager;

        $this->userManager = $userManager;
        $this->authManager = $authManager;
    }

    public function indexAction()
    {
        /** @var UserUsers $item */
        /** @var ReserveSelectionRepository $repSelection */
        if (!$this->requireUser()) return;
        if (!$this->requireAccess('user.profile', null)) return;

        $userId = (int)$this->params()->fromRoute('id');
        $page   = (int)$this->params()->fromQuery('page');
        $item   = $this->userManager->getUserById($userId);

        if ($item == null) {
            $this->getResponse()->setStatusCode(404);
            return;
        } /*elseif ($this->authManager->getIdentity() !== $item->getIdentity()) {
            $this->getResponse()->setStatusCode(403);
            return;
        }*/

        $searchData   = new SearchData();
        $repSelection = $this->entityManager->getRepository(ReserveSelection::class);
        $searchData->setUser($item->getId());
        $selections = $repSelection->searchByForm($searchData, compact('page'));

        return [
            'item'       => $item,
            'selections' => $selections
        ];
    }
}