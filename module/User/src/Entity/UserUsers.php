<?php

namespace User\Entity;

use Application\Classes\AbstractEntityItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * UserUsers
 *
 * @ORM\Table(name="user_users", uniqueConstraints={@ORM\UniqueConstraint(name="user_users_email_uindex", columns={"email"}), @ORM\UniqueConstraint(name="user_users_pin_uindex", columns={"pin"}), @ORM\UniqueConstraint(name="user_users_username_uindex", columns={"username"})}, indexes={@ORM\Index(name="IDX_F6415EB15FB14BA7", columns={"level_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="User\Entity\Repository\UserUsersRepository")
 */
class UserUsers extends AbstractEntityItem
{
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="bigint", precision=0, scale=0, nullable=false, unique=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="user_users_user_id_seq", allocationSize=1, initialValue=1)
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", precision=0, scale=0, nullable=false, unique=false)
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
     * @ORM\Column(name="pin", type="string", length=14, precision=0, scale=0, nullable=false, unique=false)
     */
    private $pin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="fname", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $fname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="lname", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $lname;

    /**
     * @var string|null
     *
     * @ORM\Column(name="pname", type="string", length=100, precision=0, scale=0, nullable=true, unique=false)
     */
    private $pname;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=60, precision=0, scale=0, nullable=true, options={"fixed"=true}, unique=false)
     */
    private $password;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="smallint", precision=0, scale=0, nullable=false, unique=false)
     */
    private $status;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", precision=0, scale=0, nullable=false, unique=false)
     */
    private $creationDate;

    /**
     * @var string
     *
     * @ORM\Column(name="locale", type="string", length=5, nullable=false, options={"fixed"=true})
     */
    private $locale;

    /**
     * @var \User\Entity\UserLevels
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\UserLevels")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="level_id", referencedColumnName="level_id", nullable=true)
     * })
     */
    private $level;

    /**
     * @var int
     *
     * @ORM\Column(name="photo_id", type="integer", precision=0, scale=0, nullable=true, unique=false)
     */
    private $photoId;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="bdate", type="date", precision=0, scale=0, nullable=false, unique=false)
     */
    private $bdate;

    public function __toString()
    {
        return $this->getFullName();
    }


    /**
     * Get userId.
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
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
     * Set pin.
     *
     * @param string $pin
     *
     * @return UserUsers
     */
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get pin.
     *
     * @return string
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set fname.
     *
     * @param string|null $fname
     *
     * @return UserUsers
     */
    public function setFname($fname = null)
    {
        $this->fname = $fname;

        return $this;
    }

    /**
     * Get fname.
     *
     * @return string|null
     */
    public function getFname()
    {
        return $this->fname;
    }

    /**
     * Set lname.
     *
     * @param string|null $lname
     *
     * @return UserUsers
     */
    public function setLname($lname = null)
    {
        $this->lname = $lname;

        return $this;
    }

    /**
     * Get lname.
     *
     * @return string|null
     */
    public function getLname()
    {
        return $this->lname;
    }

    /**
     * Set pname.
     *
     * @param string|null $pname
     *
     * @return UserUsers
     */
    public function setPname($pname = null)
    {
        $this->pname = $pname;

        return $this;
    }

    /**
     * Get pname.
     *
     * @return string|null
     */
    public function getPname()
    {
        return $this->pname;
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
     * @param int $status
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
     * @return int
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
    /**
     * @return string
     */
    public function getLocale(): string
    {
        return $this->locale;
    }

    /**
     * @param string $locale
     */
    public function setLocale(string $locale)
    {
        $this->locale = $locale;
    }

    public function getFullName()
    {
        return $this->getFname().' '.$this->getLname().' '.$this->getPname();
    }

    public function getHref()
    {
        $router = $this->sm->get('Router');

        return  $router->assemble(array('action' => 'view', 'id' => $this->getIdentity()), array('name' => 'user_profile'));
    }

    public function toArray()
    {
        $data = get_object_vars($this);
        foreach ($data as $attribute => $value) {
            if (is_object($value)) {
                $data[$attribute] = get_object_vars($value);
            }
        }
        return $data;
    }

    public function getIdentity()
    {
        return $this->getUserId();
    }

    public function getTitle()
    {
        return $this->getFullName();
    }

    /**
     * @return int
     */
    public function getPhotoId()
    {
        return $this->photoId;
    }

    /**
     * Set bdate.
     *
     * @param \DateTime $bdate
     *
     * @return UserUsers
     */
    public function setBdate($bdate)
    {
        $this->bdate = $bdate;

        return $this;
    }

    /**
     * Get bdate.
     *
     * @return \DateTime
     */
    public function getBdate()
    {
        return $this->bdate;
    }

    public function getAge($till = false)
    {
        if($this->getBdate())
        {
            $till = $till ? $till : time();
            $till = is_string($till) ? strtotime($till) : $till;
            $age = floor(($till - $this->getBdate()->getTimestamp()) / 31556926);

            return $age;
        }

        return '-';
    }

    public function getBdateWithAge($ageText)
    {
        if($this->bdate){
            return date('Y-m-d', $this->getBdate()->getTimestamp()) . '  (' . $this->getAge() . ' ' .  $ageText . ')';
        }
        return '-';
    }

    public function isAdmin()
    {
        $level = $this->getLevel();

        if($level->getType() == 'admin' || $this->isSuperAdmin())
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    public function isSuperAdmin()
    {
        $level = $this->getLevel();

        if($level->getType() == 'superadmin')
        {
            return true;
        }
        else
        {
            return false;
        }
    }
}
