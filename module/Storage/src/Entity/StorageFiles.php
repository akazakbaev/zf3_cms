<?php

namespace Storage\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StorageFiles
 *
 * @ORM\Table(name="storage_files", indexes={@ORM\Index(name="IDX_6BE18979ED5CA9E6", columns={"service_id"})})
 * @ORM\Entity
 */
class StorageFiles
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="storage_files_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var int|null
     *
     * @ORM\Column(name="parent_file_id", type="integer", nullable=true)
     */
    private $parentFileId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="type", type="string", length=20, nullable=true)
     */
    private $type;

    /**
     * @var string
     *
     * @ORM\Column(name="storage_path", type="string", length=255, precision=0, scale=0, nullable=false, unique=false)
     */
    private $storagePath;

    /**
     * @var string
     *
     * @ORM\Column(name="parent_type", type="string", length=20, nullable=false)
     */
    private $parentType;

    /**
     * @var int
     *
     * @ORM\Column(name="parent_id", type="integer", nullable=false)
     */
    private $parentId;

    /**
     * @var string
     *
     * @ORM\Column(name="extension", type="string", length=8, nullable=false)
     */
    private $extension;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, nullable=false)
     */
    private $name;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mime_major", type="string", length=64, nullable=true)
     */
    private $mimeMajor;

    /**
     * @var string|null
     *
     * @ORM\Column(name="mime_minor", type="string", length=64, nullable=true)
     */
    private $mimeMinor;

    /**
     * @var int|null
     *
     * @ORM\Column(name="size", type="bigint", nullable=true)
     */
    private $size;

    /**
     * @var string
     *
     * @ORM\Column(name="hash", type="string", length=64, nullable=false)
     */
    private $hash;

    /**
     * @var int|null
     *
     * @ORM\Column(name="owner_id", type="integer", nullable=true)
     */
    private $ownerId;

    /**
     * @var string|null
     *
     * @ORM\Column(name="owner_type", type="string", length=255, nullable=true)
     */
    private $ownerType;

    /**
     * @var \Storage\Entity\StorageServices
     *
     * @ORM\ManyToOne(targetEntity="Storage\Entity\StorageServices")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="service_id", referencedColumnName="id")
     * })
     */
    private $service;

    private $tmpName;

    private $error;

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
     * @return int|null
     */
    public function getParentFileId(): ?int
    {
        return $this->parentFileId;
    }

    /**
     * @param int|null $parentFileId
     */
    public function setParentFileId(?int $parentFileId): void
    {
        $this->parentFileId = $parentFileId;
    }

    /**
     * @return null|string
     */
    public function getType(): ?string
    {
        return $this->type;
    }

    /**
     * @param null|string $type
     */
    public function setType(?string $type): void
    {
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getStoragePath(): string
    {
        return $this->storagePath;
    }

    /**
     * @param string $storagePath
     */
    public function setStoragePath(string $storagePath): void
    {
        $this->storagePath = $storagePath;
    }

    /**
     * @return string
     */
    public function getParentType(): string
    {
        return $this->parentType;
    }

    /**
     * @param string $parentType
     */
    public function setParentType(string $parentType): void
    {
        $this->parentType = $parentType;
    }

    /**
     * @return int
     */
    public function getParentId(): int
    {
        return $this->parentId;
    }

    /**
     * @param int $parentId
     */
    public function setParentId(int $parentId): void
    {
        $this->parentId = $parentId;
    }

    /**
     * @return string
     */
    public function getExtension(): string
    {
        return $this->extension;
    }

    /**
     * @param string $extension
     */
    public function setExtension(string $extension): void
    {
        $this->extension = $extension;
    }

    /**
     * @return string
     */
    public function getName(): string
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
    public function getMimeMajor(): ?string
    {
        return $this->mimeMajor;
    }

    /**
     * @param null|string $mimeMajor
     */
    public function setMimeMajor(?string $mimeMajor): void
    {
        $this->mimeMajor = $mimeMajor;
    }

    /**
     * @return null|string
     */
    public function getMimeMinor(): ?string
    {
        return $this->mimeMinor;
    }

    /**
     * @param null|string $mimeMinor
     */
    public function setMimeMinor(?string $mimeMinor): void
    {
        $this->mimeMinor = $mimeMinor;
    }

    /**
     * @return int|null
     */
    public function getSize(): ?int
    {
        return $this->size;
    }

    /**
     * @param int|null $size
     */
    public function setSize(?int $size): void
    {
        $this->size = $size;
    }

    /**
     * @return string
     */
    public function getHash(): string
    {
        return $this->hash;
    }

    /**
     * @param string $hash
     */
    public function setHash(string $hash): void
    {
        $this->hash = $hash;
    }

    /**
     * @return int|null
     */
    public function getOwnerId(): ?int
    {
        return $this->ownerId;
    }

    /**
     * @param int|null $ownerId
     */
    public function setOwnerId(?int $ownerId): void
    {
        $this->ownerId = $ownerId;
    }

    /**
     * @return null|string
     */
    public function getOwnerType(): ?string
    {
        return $this->ownerType;
    }

    /**
     * @param null|string $ownerType
     */
    public function setOwnerType(?string $ownerType): void
    {
        $this->ownerType = $ownerType;
    }

    /**
     * @return StorageServices
     */
    public function getService(): StorageServices
    {
        return $this->service;
    }

    /**
     * @param StorageServices $service
     */
    public function setService(StorageServices $service): void
    {
        $this->service = $service;
    }

    /**
     * @return mixed
     */
    public function getTmpName()
    {
        return $this->tmpName;
    }

    /**
     * @param mixed $tmpName
     */
    public function setTmpName($tmpName): void
    {
        $this->tmpName = $tmpName;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error): void
    {
        $this->error = $error;
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

    public function map()
    {

        $store = $this->getService()->getStoreService();

        if($store)
            return $store->map($this);

        return null;
    }
}
