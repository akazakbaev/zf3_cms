<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApplicationTranslates
 *
 * @ORM\Table(name="application_translates", indexes={@ORM\Index(name="application_translates_application_translate_key__fk", columns={"translate_key_id"})})
 * @ORM\Entity
 */
class ApplicationTranslates
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
     * @ORM\Column(name="locale", type="text", length=5, nullable=false)
     */
    private $locale;

    /**
     * @var string
     *
     * @ORM\Column(name="translate", type="text", length=65535, nullable=false)
     */
    private $translate;

    /**
     * @var \Application\Entity\ApplicationTranslateKey
     *
     * @ORM\ManyToOne(targetEntity="Application\Entity\ApplicationTranslateKey")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="translate_key_id", referencedColumnName="id")
     * })
     */
    private $translateKey;

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getLocale()
    {
        return $this->locale;
    }

    /**
     * @param int $locale
     */
    public function setLocale($locale)
    {
        $this->locale = $locale;
    }

    /**
     * @return string
     */
    public function getTranslate()
    {
        return $this->translate;
    }

    /**
     * @param string $translate
     */
    public function setTranslate($translate)
    {
        $this->translate = $translate;
    }

    /**
     * @return ApplicationTranslateKey
     */
    public function getTranslateKey()
    {
        return $this->translateKey;
    }

    /**
     * @param ApplicationTranslateKey $translateKey
     */
    public function setTranslateKey($translateKey)
    {
        $this->translateKey = $translateKey;
    }


}
