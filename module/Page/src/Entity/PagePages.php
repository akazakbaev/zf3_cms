<?php

namespace Page\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PagePages
 *
 * @ORM\Table(name="page_pages", indexes={@ORM\Index(name="page_pages_user_users__fk", columns={"user_id"})})
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Page\Entity\Repository\PagePagesRepository")
 */
class PagePages
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


}
