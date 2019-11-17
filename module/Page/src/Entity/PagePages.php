<?php

namespace Page\Entity;

use Application\Classes\AbstractEntityItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * PagePages
 *
 * @ORM\Table(name="page_pages", indexes={@ORM\Index(name="page_pages_user_users__fk", columns={"user_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Page\Entity\Repository\PagePagesRepository")
 */
class PagePages extends AbstractEntityItem
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title_en", type="string", length=255, nullable=true)
     */
    private $titleEn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="title_ru", type="string", length=255, nullable=true)
     */
    private $titleRu;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_en", type="text", length=0, nullable=true)
     */
    private $descriptionEn;

    /**
     * @var string|null
     *
     * @ORM\Column(name="description_ru", type="text", length=0, nullable=true)
     */
    private $descriptionRu;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="creation_date", type="datetime", nullable=false)
     */
    private $creationDate;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="modified_date", type="datetime", nullable=false)
     */
    private $modifiedDate;

    /**
     * @var \User\Entity\UserUsers
     *
     * @ORM\ManyToOne(targetEntity="User\Entity\UserUsers")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     * })
     */
    private $user;

    public function __construct()
    {
        $this->creationDate = new \DateTime('now');
        $this->modifiedDate = new \DateTime('now');
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return null|string
     */
    public function getTitleEn(): ?string
    {
        return $this->titleEn;
    }

    /**
     * @param null|string $titleEn
     */
    public function setTitleEn(?string $titleEn): void
    {
        $this->titleEn = $titleEn;
    }

    /**
     * @return null|string
     */
    public function getTitleRu(): ?string
    {
        return $this->titleRu;
    }

    /**
     * @param null|string $titleRu
     */
    public function setTitleRu(?string $titleRu): void
    {
        $this->titleRu = $titleRu;
    }

    /**
     * @return null|string
     */
    public function getDescriptionEn(): ?string
    {
        return $this->descriptionEn;
    }

    /**
     * @param null|string $descriptionEn
     */
    public function setDescriptionEn(?string $descriptionEn): void
    {
        $this->descriptionEn = $descriptionEn;
    }

    /**
     * @return null|string
     */
    public function getDescriptionRu(): ?string
    {
        return $this->descriptionRu;
    }

    /**
     * @param null|string $descriptionRu
     */
    public function setDescriptionRu(?string $descriptionRu): void
    {
        $this->descriptionRu = $descriptionRu;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): \DateTime
    {
        return $this->creationDate;
    }

    /**
     * @param \DateTime $creationDate
     */
    public function setCreationDate(\DateTime $creationDate): void
    {
        $this->creationDate = $creationDate;
    }

    /**
     * @return \DateTime
     */
    public function getModifiedDate(): \DateTime
    {
        return $this->modifiedDate;
    }

    /**
     * @param \DateTime $modifiedDate
     */
    public function setModifiedDate(\DateTime $modifiedDate): void
    {
        $this->modifiedDate = $modifiedDate;
    }

    /**
     * @return \User\Entity\UserUsers
     */
    public function getUser(): ?\User\Entity\UserUsers
    {
        return $this->user;
    }

    /**
     * @param \User\Entity\UserUsers $user
     */
    public function setUser(?\User\Entity\UserUsers $user): void
    {
        $this->user = $user;
    }


}
