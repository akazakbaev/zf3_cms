<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use User\Entity\UserLevels;
use User\Entity\UserPermissions;
use Doctrine\Common\Collections\ArrayCollection;
/**
 * UserAllows
 *
 * @ORM\Table(name="user_allows", uniqueConstraints={@ORM\UniqueConstraint(name="user_allows_level_id_permission_id_pk", columns={"level_id", "permission_id"})}, indexes={@ORM\Index(name="IDX_D0F3F73C5FB14BA7", columns={"level_id"}), @ORM\Index(name="IDX_D0F3F73CFED90CCA", columns={"permission_id"})})
 * @ORM\Entity
 */
class UserAllows
{
    /**
     * @var int
     *
     * @ORM\Column(name="allow_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_allows_allow_id_seq", allocationSize=1, initialValue=1)
     */
    private $allowId;

    /**
     * @var \User\Entity\UserLevels
     *
     * @ORM\ManyToOne(targetEntity="UserLevels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="level_id", referencedColumnName="level_id", nullable=true)
     * })
     */
    private $level;

    /**
     * @var \User\Entity\UserPermissions
     *
     * @ORM\OneToOne(targetEntity="UserPermissions")
     *   @ORM\JoinColumn(name="permission_id", referencedColumnName="permission_id")
     */
    private $permission;


    /**
     * Get allowId.
     *
     * @return int
     */
    public function getAllowId()
    {
        return $this->allowId;
    }

    /**
     * Set level.
     *
     * @param \User\Entity\UserLevels|null $level
     *
     * @return \User\UserAllows
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
