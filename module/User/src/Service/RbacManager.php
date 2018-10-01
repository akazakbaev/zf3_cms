<?php
namespace User\Service;

use Zend\Permissions\Rbac\Rbac;
use Zend\Permissions\Rbac\Role as RbacRole;
use User\Entity\UserUsers;
use User\Entity\UserLevels;
use User\Entity\Permission;

/**
 * This service is responsible for initialzing RBAC (Role-Based Access Control).
 */
class RbacManager 
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager; 
    
    /**
     * RBAC service.
     * @var \Zend\Permissions\Rbac\Rbac
     */
    private $rbac;
    
    /**
     * Auth service.
     * @var \User\Service\AuthManager
     */
    private $authManager;
    
    /**
     * Filesystem cache.
     * @var \Zend\Cache\Storage\StorageInterface
     */
    private $cache;
    
    /**
     * Assertion managers.
     * @var array
     */
    private $assertionManagers = [];
    
    /**
     * Constructs the service.
     */
    public function __construct($entityManager, $authManager, $cache, $assertionManagers)
    {
        $this->entityManager = $entityManager;
        $this->authManager = $authManager;
        $this->cache = $cache;
        $this->assertionManagers = $assertionManagers;
    }
    
    /**
     * Initializes the RBAC container.
     */
    public function init($forceCreate = false)
    {
        if ($this->rbac!=null && !$forceCreate) {
            // Already initialized; do nothing.
            return;
        }
        
        // If user wants us to reinit RBAC container, clear cache now.
        if ($forceCreate)
        {
            $this->cache->removeItem('rbac_container');
        }
        
        // Try to load Rbac container from cache.
        $result = false;
        $this->rbac = $this->cache->getItem('rbac_container', $result);
        if (!$result)
        {
            // Create Rbac container.
            $rbac = new Rbac();
            $this->rbac = $rbac;

            // Construct role hierarchy by loading roles and permissions from database.

            $rbac->setCreateMissingRoles(true);

            $roles = $this->entityManager->getRepository(UserLevels::class)
                    ->findBy([], ['levelId'=>'ASC']);

            foreach ($roles as $role)
            {

                $roleName = $this->getLevelName($role);

                $rbac->addRole($roleName, []);


                foreach ($role->getAllows() as $allow)
                {
                    $rbac->getRole($roleName)->addPermission($allow->getPermission()->getName());
                }
            }
            
            // Save Rbac container to cache.
            $this->cache->setItem('rbac_container', $rbac);
        }
    }
    
    /**
     * Checks whether the given user has permission.
     * @param UserUsers|null $user
     * @param string $permission
     * @param array|null $params
     * @return boolean
     */
    public function isGranted($user, $permission, $params = null)
    {
        if ($this->rbac==null)
            $this->init();

        if ($user == null)
        {
            $user = $this->authManager->getViewer();

            if ($user->getUserId() == null)
            {
                return false;
            }
        }
        
        $level = $user->getLevel();

        if ($this->rbac->isGranted($this->getLevelName($level), $permission))
        {
            if ($params==null)
                return true;

            foreach ($this->assertionManagers as $assertionManager)
            {
                if ($assertionManager->assert($this->rbac, $permission, $params))
                    return true;
            }

            return false;
        }

        
        return false;
    }

    public function removeCache()
    {
        $this->cache->removeItem('rbac_container');
    }

    private function getLevelName(UserLevels $level)
    {
        return $level->getType()->getValue().'_'.$level->getLevelId();
    }
}



