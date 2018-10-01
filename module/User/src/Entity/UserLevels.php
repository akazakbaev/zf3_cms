<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use User\Entity\UserAllows;

/**
 * UserLevels
 *
 * @ORM\Table(name="user_levels")
 * @ORM\Entity
 */
class UserLevels
{
    /**
     * @var int
     *
     * @ORM\Column(name="level_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_levels_level_id_seq", allocationSize=1, initialValue=1)
     */
    private $levelId;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=20, precision=0, scale=0, nullable=false, unique=false)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description", type="text", precision=0, scale=0, nullable=true, unique=false)
     */
    private $description;

    /**
     * @var role_types|null
     *
     * @ORM\Column(name="type", type="role_types", precision=0, scale=0, nullable=true, unique=false)
     */
    private $type;


    /**
     * One Product has Many Allows.
     * @ORM\OneToMany(targetEntity="UserAllows", mappedBy="level")
     */
    private $allows;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->allows = new ArrayCollection();
    }

    /**
     * Get levelId.
     *
     * @return int
     */
    public function getLevelId()
    {
        return $this->levelId;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return UserLevels
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set description.
     *
     * @param string|null $description
     *
     * @return UserLevels
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
     * Set type.
     *
     * @param role_types|null $type
     *
     * @return UserLevels
     */
    public function setType($type = null)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type.
     *
     * @return role_types|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return mixed
     */
    public function getAllows()
    {
        return $this->allows;
    }

    /**
     * @param mixed $allows
     */
    public function setAllows($allows)
    {
        $this->allows = $allows;
    }

}
