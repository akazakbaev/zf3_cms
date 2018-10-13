<?php

namespace Storage\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StorageTypes
 *
 * @ORM\Table(name="storage_types", uniqueConstraints={@ORM\UniqueConstraint(name="storage_types_plugin_uindex", columns={"plugin"})})
 * @ORM\Entity
 */
class StorageTypes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="storage_types_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=128, nullable=false)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="plugin", type="string", length=128, nullable=false)
     */
    private $plugin;

    /**
     * @var string|null
     *
     * @ORM\Column(name="form", type="string", length=128, nullable=true)
     */
    private $form;

    /**
     * @var int|null
     *
     * @ORM\Column(name="enabled", type="integer", nullable=true)
     */
    private $enabled;

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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return string
     */
    public function getPlugin(): string
    {
        return $this->plugin;
    }

    /**
     * @param string $plugin
     */
    public function setPlugin(string $plugin): void
    {
        $this->plugin = $plugin;
    }

    /**
     * @return null|string
     */
    public function getForm(): ?string
    {
        return $this->form;
    }

    /**
     * @param null|string $form
     */
    public function setForm(?string $form): void
    {
        $this->form = $form;
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


}
