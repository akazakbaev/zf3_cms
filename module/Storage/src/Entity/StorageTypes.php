<?php

namespace Storage\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StorageTypes
 *
 * @ORM\Table(name="storage_types")
 * @ORM\Entity
 */
class StorageTypes
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
     * @ORM\Column(name="title", type="string", length=128, nullable=true)
     */
    private $title;

    /**
     * @var string|null
     *
     * @ORM\Column(name="plugin", type="string", length=128, nullable=true)
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
     * @return null|string
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * @param null|string $title
     */
    public function setTitle(?string $title): void
    {
        $this->title = $title;
    }

    /**
     * @return null|string
     */
    public function getPlugin(): ?string
    {
        return $this->plugin;
    }

    /**
     * @param null|string $plugin
     */
    public function setPlugin(?string $plugin): void
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
