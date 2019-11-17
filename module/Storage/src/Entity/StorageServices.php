<?php

namespace Storage\Entity;

use Doctrine\ORM\Mapping as ORM;
use Storage\Exception\StoreException;
use Storage\Storage\AbstractService;
/**
 * StorageServices
 *
 * @ORM\Table(name="storage_services", indexes={@ORM\Index(name="storage_services_storage_types__fk", columns={"type_id"})})
 * @ORM\Entity
 */
class StorageServices
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
     * @var string|null
     *
     * @ORM\Column(name="config", type="text", length=65535, nullable=true)
     */
    private $config;

    /**
     * @var int|null
     *
     * @ORM\Column(name="enabled", type="smallint", nullable=true)
     */
    private $enabled;

    /**
     * @var int|null
     *
     * @ORM\Column(name="default", type="smallint", nullable=true)
     */
    private $default;

    /**
     * @var \Storage\Entity\StorageTypes
     *
     * @ORM\ManyToOne(targetEntity="Storage\Entity\StorageTypes")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * })
     */
    private $type;

    /**
     * @return int
     */
    public function getId(): int
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
     * @return null|string
     */
    public function getConfig(): ?string
    {
        return $this->config;
    }

    /**
     * @param null|string $config
     */
    public function setConfig(?string $config): void
    {
        $this->config = $config;
    }

    /**
     * @return int|null
     */
    public function getEnabled(): ?int
    {
        return $this->enabled;
    }

    /**
     * @param int|null $enabled
     */
    public function setEnabled(?int $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return int|null
     */
    public function getDefault(): ?int
    {
        return $this->default;
    }

    /**
     * @param int|null $default
     */
    public function setDefault(?int $default): void
    {
        $this->default = $default;
    }

    /**
     * @return StorageTypes
     */
    public function getType(): StorageTypes
    {
        return $this->type;
    }

    /**
     * @param StorageTypes $type
     */
    public function setType(StorageTypes $type): void
    {
        $this->type = $type;
    }

    /**
     * @return AbstractService
     * @throws StoreException
     */
    public function  getStoreService()
    {
        /** @var StorageTypes $type */
        if($this->getType() === null)
        {
            throw new StoreException('Missing storage service type');
        }

        $type = $this->getType();

        $class = $type->getPlugin();

        if(!class_exists($class) ||
            !in_array('Storage\Provider\StorageInterface', class_implements($class)))
        {
            throw new StoreException('Missing storage service ' .
                'class or does not implement Storage\Provider\StorageInterface for service');
        }

        $config = [];

        if( $this->getConfig())
        {
            $config = $this->getConfig();
            if( !is_array($config) ) {
                $config = [];
            }
        }

        return new $class($config);
    }
}
