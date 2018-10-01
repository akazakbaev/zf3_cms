<?php

namespace User\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\DateType;

/**
 * UserLogins
 *
 * @ORM\Table(name="user_logins", indexes={@ORM\Index(name="user_logins_user_id_index", columns={"user_id"}), @ORM\Index(name="user_logins_username_index", columns={"username"})})
 * @ORM\Entity
 */
class UserLogins
{
    /**
     * @var int
     *
     * @ORM\Column(name="login_id", type="integer", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_logins_login_id_seq", allocationSize=1, initialValue=1)
     */
    private $loginId;

    /**
     * @var int|null
     *
     * @ORM\Column(name="user_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $userId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="username", type="string", length=50, precision=0, scale=0, nullable=true, unique=false)
     */
    private $username;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", precision=0, scale=0, nullable=false, unique=false)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="ip", type="string", precision=0, scale=0, nullable=false, unique=false)
     */
    private $ip;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $creationDate;


    /**
     * Get loginId.
     *
     * @return int
     */
    public function getLoginId()
    {
        return $this->loginId;
    }

    /**
     * Set userId.
     *
     * @param int|null $userId
     *
     * @return UserLogins
     */
    public function setUserId($userId = null)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId.
     *
     * @return int|null
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set username.
     *
     * @param string|null $username
     *
     * @return UserLogins
     */
    public function setUsername($username = null)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username.
     *
     * @return string|null
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set status.
     *
     * @param int $status
     *
     * @return UserLogins
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status.
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set ip.
     *
     * @param string $ip
     *
     * @return UserLogins
     */
    public function setIp($ip)
    {
        $this->ip = $ip;

        return $this;
    }

    /**
     * Get ip.
     *
     * @return string
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * Set creationDate.
     *
     * @param \DateTime $creationDate
     *
     * @return UserLogins
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
}
