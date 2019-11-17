<?php

namespace Application\Entity;

use Application\Classes\AbstractEntityItem;
use Doctrine\ORM\Mapping as ORM;

/**
 * ApplicationTeams
 *
 * @ORM\Table(name="application_teams")
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Application\Entity\Repository\ApplicationTeamsRepository")
 */
class ApplicationTeams extends AbstractEntityItem
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


}
