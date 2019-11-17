<?php

namespace Application\Entity;

use Application\Classes\AbstractEntityItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * ApplicationSliders
 *
 * @ORM\Table(name="application_sliders", indexes={@ORM\Index(name="application_sliders_storage_files__fk", columns={"file_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\Repository\ApplicationSlidersRepository")
 */
class ApplicationSliders extends AbstractEntityItem
{
    const STATUS_ENABLE = 1;
    const STATUS_DISABLE = 2;

    const STATUSES = [
            self::STATUS_ENABLE => 'Enable',
            self::STATUS_DISABLE => 'Disable'
        ];

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
     * @var string
     *
     * @ORM\Column(name="description_en", type="text", length=65535, nullable=false)
     */
    private $descriptionEn;

    /**
     * @var string
     *
     * @ORM\Column(name="description_ru", type="text", length=65535, nullable=false)
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
     * @var int
     *
     * @ORM\Column(name="status", type="integer", precision=0, scale=0, nullable=false, options={"default"="1"}, unique=false)
     */
    private $status = '1';

    /**
     * @var string
     *
     * @ORM\Column(name="link", type="string", length=255, nullable=true)
     */
    private $link;

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
     * @return string
     */
    public function getDescriptionEn(): ?string
    {
        return $this->descriptionEn;
    }

    /**
     * @param string $descriptionEn
     */
    public function setDescriptionEn(string $descriptionEn): void
    {
        $this->descriptionEn = $descriptionEn;
    }

    /**
     * @return string
     */
    public function getDescriptionRu(): ?string
    {
        return $this->descriptionRu;
    }

    /**
     * @param string $descriptionRu
     */
    public function setDescriptionRu(string $descriptionRu): void
    {
        $this->descriptionRu = $descriptionRu;
    }

    /**
     * @return \DateTime
     */
    public function getCreationDate(): ?\DateTime
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
    public function getModifiedDate(): ?\DateTime
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

    /**
     * @return string
     */
    public function getLink(): ?string
    {
        return $this->link;
    }

    /**
     * @param string $link
     */
    public function setLink(string $link): void
    {
        $this->link = $link;
    }
    /**
     * @return bool
     */
    public function isStatus(): bool
    {
        return $this->status;
    }

    /**
     * @return bool
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * @param bool $status
     */
    public function setStatus($status): void
    {
        $this->status = $status;
    }

    public function getStatusText()
    {
        return self::STATUSES[$this->getStatus()];
    }
}
