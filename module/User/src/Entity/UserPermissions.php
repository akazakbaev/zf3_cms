<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use User\Entity\UserAllows;

/**
 * UserPermissions
 *
 * @ORM\Table(name="user_permissions", uniqueConstraints={@ORM\UniqueConstraint(name="user_permission_name_uindex", columns={"name"})})
 * @ORM\Entity
 */
class UserPermissions
{
    /**
     * @var int
     *
     * @ORM\Column(name="permission_id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_permissions_permission_id_seq", allocationSize=1, initialValue=1)
     */
    private $permissionId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * Get permissionId.
     *
     * @return int
     */
    public function getPermissionId()
    {
        return $this->permissionId;
    }

    /**
     * Set name.
     *
     * @param string $name
     *
     * @return UserPermission
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return UserPermission
     */
    public function setDescription($description = null)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getAllow()
    {
        return $this->allow;
    }
}
