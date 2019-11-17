<?php

namespace Article\Entity;

use Application\Classes\AbstractEntityItem;
use Doctrine\ORM\Mapping as ORM;
use User\Entity\UserUsers;

/**
 * ArticleArticles
 *
 * @ORM\Table(name="article_articles", indexes={@ORM\Index(name="article_articles_user_users__fk", columns={"user_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Article\Entity\Repository\ArticleArticlesRepository")
 */
class ArticleArticles extends AbstractEntityItem
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
     * @ORM\Column(name="title_en", type="string", length=255, nullable=false)
     */
    private $titleEn;

    /**
     * @var string
     *
     * @ORM\Column(name="title_ru", type="string", length=255, nullable=false)
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
     * @var int
     *
     * @ORM\Column(name="file_id", type="integer", nullable=true)
     */
    private $fileId;

    /**
     * @var \Storage\Entity\StorageFiles
     *
     * @ORM\ManyToOne(targetEntity="Storage\Entity\StorageFiles")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="file_id", referencedColumnName="id")
     * })
     */
    private $file;

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
    public function getTitleEn(): ?string
    {
        return $this->titleEn;
    }

    /**
     * @param string $titleEn
     */
    public function setTitleEn(string $titleEn): void
    {
        $this->titleEn = $titleEn;
    }

    /**
     * @return string
     */
    public function getTitleRu(): ?string
    {
        return $this->titleRu;
    }

    /**
     * @param string $titleRu
     */
    public function setTitleRu(string $titleRu): void
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
     * @return UserUsers
     */
    public function getUser(): ?UserUsers
    {
        return $this->user;
    }

    /**
     * @param UserUsers $user
     */
    public function setUser(UserUsers $user): void
    {
        $this->user = $user;
    }

    /**
     * @return \Storage\Entity\StorageFiles
     */
    public function getFile(): ?\Storage\Entity\StorageFiles
    {
        return $this->file;
    }

    /**
     * @param \Storage\Entity\StorageFiles $file
     */
    public function setFile(\Storage\Entity\StorageFiles $file): void
    {
        $this->file = $file;
    }

    /**
     * @return int
     */
    public function getFileId(): ?int
    {
        return $this->fileId;
    }

    /**
     * @param int $fileId
     */
    public function setFileId(int $fileId): void
    {
        $this->fileId = $fileId;
    }

    public function getHref()
    {
        $router = $this->getServiceLocator()->get('Application')->getMvcEvent()->getRouter();

        return  $router->assemble(['action' => 'view', 'id' => $this->getId()], ['name' => 'articles_general']);
    }
}
