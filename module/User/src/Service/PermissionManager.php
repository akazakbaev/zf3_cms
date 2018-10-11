<?php
namespace User\Service;

use User\Entity\UserAllows;
use User\Entity\UserLevels;
use User\Entity\UserPermissions;

class PermissionManager
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \User\Service\AuthManager;
     */
    private $authManager;

    /**
     * @var \User\Service\RbacManager;
     */
    private $rbacManager;

    private $translator;

    /**
     * Constructs the service.
     */
    public function __construct($entityManager, $authManager, $rbacManager, $translator)
    {
        $this->entityManager = $entityManager;

        $this->authManager = $authManager;

        $this->rbacManager = $rbacManager;

        $this->translator = $translator;
    }

    public function getLevelsList($filtered = false)
    {
        $items = $this->entityManager->getRepository(UserLevels::class)->findAll();

        $data = [];

        foreach ($items as $item)
        {
            $data[$item->getId()] = $item->getTitle();
        }

        if($filtered)
        {
            unset($data[3]);
            unset($data[4]);
            unset($data[5]);
            unset($data[6]);
        }

        return $data;
    }

    public function getLevel($id)
    {
        return $this->entityManager->getRepository(UserLevels::class)->find($id);
    }

    public function preparePermissionOptions($level)
    {
        $items = $this->entityManager->getRepository(UserPermissions::class)->findAll();

        $data = [];

//        $level = $this->authManager->getViewer()->getLevel();

        $allows = $level->getAllows();

        $allowsData = [];

        foreach ($allows as $allow)
        {
            $id = $allow->getPermission()->getId();
            $allowsData[$id] = $id;
        }

        /**
         * @var $item UserPermissions;
         */
        foreach ($items as $item)
        {
            $data[] = [
             'value' => $item->getId(),
                'label' => $item->getDescription(),
                'selected' => (in_array($item->getId(), $allowsData) ? true : false)
            ];
        }

        return $data;
    }

    public function save($params = [])
    {
        $level = $this->entityManager->getRepository(UserLevels::class)->find($params['level_id']);

        $allows = $level->getAllows();

        foreach ($allows as $allow)
        {
            $this->entityManager->remove($allow);
            $this->entityManager->flush();
        }

        foreach ($params['permissions'] as $k => $v)
        {
            $permission = $this->entityManager->getRepository(UserPermissions::class)->find($v);

            $allow = new UserAllows();

            $allow->setPermission($permission);
            $allow->setLevel($level);

            $this->entityManager->persist($allow);

            // Apply changes.
            $this->entityManager->flush();
        }

        $this->rbacManager->removeCache();
    }

}

