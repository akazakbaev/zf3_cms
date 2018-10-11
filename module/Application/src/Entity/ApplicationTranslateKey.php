<?php

namespace Application\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ApplicationTranslateKey
 *
 * @ORM\Table(name="application_translate_key")
 * @ORM\Entity
 */
class ApplicationTranslateKey
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
     * @ORM\Column(name="module", type="string", length=20, nullable=false)
     */
    private $module;

    /**
     * @var string
     *
     * @ORM\Column(name="translate_text", type="text", length=65535, nullable=false)
     */
    private $translateText;

    /**
     * @var bool|null
     *
     * @ORM\Column(name="js", type="boolean", nullable=true)
     */
    private $js = '0';

    /**
     * One Product has Many Features.
     * @ORM\OneToMany(targetEntity="Application\Entity\ApplicationTranslates", mappedBy="translateKey")
     */
    private $translates;

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
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param string $module
     */
    public function setModule($module)
    {
        $this->module = $module;
    }

    /**
     * @return string
     */
    public function getTranslateText()
    {
        return $this->translateText;
    }

    /**
     * @param string $translateText
     */
    public function setTranslateText($translateText)
    {
        $this->translateText = $translateText;
    }

    /**
     * @return bool|null
     */
    public function getJs()
    {
        return $this->js;
    }

    /**
     * @param bool|null $js
     */
    public function setJs($js)
    {
        $this->js = $js;
    }

    /**
     * @return mixed
     */
    public function getTranslates()
    {
        return $this->translates;
    }

    /**
     * @param mixed $translates
     */
    public function setTranslates($translates)
    {
        $this->translates = $translates;
    }
}
