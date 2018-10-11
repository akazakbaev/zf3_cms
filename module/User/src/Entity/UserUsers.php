<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UserUsers
 *
 * @ORM\Table(name="user_users", uniqueConstraints={@ORM\UniqueConstraint(name="user_users_email_uindex", columns={"email"}), @ORM\UniqueConstraint(name="user_users_username_uindex", columns={"username"})}, indexes={@ORM\Index(name="user_users_user_levels__fk", columns={"level_id"})})
 * @ORM\Entity(repositoryClass="User\Entity\Repository\UserUsersRepository")
 */
class UserUsers
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=128, precision=0, scale=0, nullable=false, unique=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=128, precision=0, scale=0, nullable=false, unique=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60, precision=0, scale=0, nullable=false, unique=false)
     */
    private $password;

    /**
     * @var bool
     *
     * @ORM\Column(name="status", type="boolean", precision=0, scale=0, nullable=false, options={"default"="1"}, unique=false)
     */
    private $status = '1';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $creationDate;

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
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set email.
     *
     * @param string $email
     *
     * @return UserUsers
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set username.
     *
     * @param string $username
     *
     * @return UserUsers
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set password.
     *
     * @param string $password
     *
     * @return UserUsers
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password.
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set status.
     *
     * @param bool $status
     *
     * @return UserUsers
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return UserUsers
     */
    public function setCreationDate($creationDate)
    {
        $this->creationDate = $creationDate;

        return $this;
    }

    /**
     * Get creationDate.
     *
     * @return \DateTime
     */
    public function getCreationDate()
    {
        return $this->creationDate;
    }

    /**
     * Set level.
     *
     * @param \User\Entity\UserLevels|null $level
     *
     * @return UserUsers
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
}
