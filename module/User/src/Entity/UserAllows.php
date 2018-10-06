<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserAllows
 *
 * @ORM\Table(name="user_allows", indexes={@ORM\Index(name="user_allows_user_levels__fk", columns={"level_id"}), @ORM\Index(name="user_allows_user_permissions__fk", columns={"permission_id"})})
 * @ORM\Entity
 */
class UserAllows
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var \User\Entity\UserLevels
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\UserLevels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="level_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $level;

    /**
     * @var \User\Entity\UserPermissions
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\UserPermissions")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="permission_id", referencedColumnName="id", nullable=true)
     * })
     */
    private $permission;


    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set level.
     *
     * @param \User\Entity\UserLevels|null $level
     *
     * @return UserAllows
     */
    public function setLevel(\User\Entity\UserLevels $level = null)
    {
        $this->level = $level;

        return $this;
    }

    /**
     * Get level.
     *
     * @return \User\Entity\UserLevels|null
     */
    public function getLevel()
    {
        return $this->level;
    }

    /**
     * Set permission.
     *
     * @param \User\Entity\UserPermissions|null $permission
     *
     * @return UserAllows
     */
    public function setPermission(\User\Entity\UserPermissions $permission = null)
    {
        $this->permission = $permission;

        return $this;
    }

    /**
     * Get permission.
     *
     * @return \User\Entity\UserPermissions|null
     */
    public function getPermission()
    {
        return $this->permission;
    }
}
