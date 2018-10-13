<?php

namespace Storage\Entity;

use Doctrine\ORM\Mapping as ORM;
use Storage\Exception\StoreException;
use Storage\Storage\AbstractService;

/**
 * StorageServices
 *
 * @ORM\Table(name="storage_services", indexes={@ORM\Index(name="IDX_D0F9DD2EC54C8C93", columns={"type_id"})})
 * @ORM\Entity
 */
class StorageServices
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="storage_services_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var jsonb|null
     *
     * @ORM\Column(name="config", type="jsonb", nullable=true)
     */
    private $config;

    /**
     * @var int
     *
     * @ORM\Column(name="enabled", type="smallint", nullable=false)
     */
    private $enabled = '0';

    /**
     * @var int
     *
     * @ORM\Column(name="default", type="smallint", nullable=false)
     */
    private $default = '0';

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
     * @return int
     */
    public function getEnabled(): int
    {
        return $this->enabled;
    }

    /**
     * @param int $enabled
     */
    public function setEnabled(int $enabled): void
    {
        $this->enabled = $enabled;
    }

    /**
     * @return int
     */
    public function getDefault(): int
    {
        return $this->default;
    }

    /**
     * @param int $default
     */
    public function setDefault(int $default): void
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
     * @return null|jsonb
     */
    public function getConfig()
    {
        return $this->config;
    }

    /**
     * @param null|jsonb $config
     */
    public function setConfig( $config): void
    {
        $this->config = $config;
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

        $config = array();

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
