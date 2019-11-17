<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/12/18
 * Time: 6:55 PM
 */
namespace Application\Controller\Plugin;

use Application\Options\LanguageOptions;
use Zend\Mvc\Controller\Plugin\AbstractPlugin;

/**
 * Class Viewer
 * @package Application\Controller\Plugin
 */
class Languages extends AbstractPlugin
{
    /**
     * @var LanguageOptions
     */
    private $languageOptions;

    public function __construct(LanguageOptions $languageOptions)
    {
        $this->languageOptions = $languageOptions;
    }

    /**
     * @return array
     */
    public function __invoke()
    {
        return $this->languageOptions->getLanguages();
    }
}