<?php

namespace Application\Options;

use Zend\Authentication\AuthenticationService;
use Zend\Stdlib\AbstractOptions;

class LanguageOptions extends AbstractOptions
{
    /**
     * Array of languages allowed for language route. The key is the prefix
     * which is attached to the url (e.g. en), the value is the associated
     * locale  (e.g. 'en_US')
     * @var array
     */
    protected $languages = ['ru' => 'ru_RU', 'en' => 'en_EN'];

    /**
     * This route name will be used if no RouteMatch instance is provided to
     * the languageSwitch ViewHelper. This happens for example if a 404 error
     * occurs.
     * @var string
     */
    protected $homeRoute = 'home';

    /**
     * Default locale.
     *
     * @var string
     */
    protected $defaultLocale = 'ru_RU';

    /**
     * Strategies, which are used for extracting locale
     *
     * @var array
     */
    protected $extractStrategies = [];

    /**
     * Strategies, which are used to save locale to
     *
     * @var array
     */
    protected $persistStrategies = [];

    /**
     * @var string
     */
    protected $authService = AuthenticationService::class;

    /**
     * @return string
     */
    public function getDefaultLocale()
    {
        return $this->defaultLocale;
    }

    /**
     * @param string $defaultLocale
     */
    public function setDefaultLocale($defaultLocale)
    {
        $this->defaultLocale = $defaultLocale;
    }

    public function getStrategyOptions($class)
    {
        $result = null;
        foreach ($this->getExtractStrategies() as $strategy) {
            if (is_array($strategy) && array_key_exists('name', $strategy)
                && array_key_exists('options', $strategy)
            ) {
                if ($strategy['name'] === $class) {
                    $result = $strategy['options'];
                }
            }
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getExtractStrategies()
    {
        return $this->extractStrategies;
    }

    /**
     * @param array $extractStrategies
     */
    public function setExtractStrategies($extractStrategies)
    {
        foreach ($extractStrategies as $strategy) {
            $this->extractStrategies[] = $strategy;
        }
    }


    function getLanguages()
    {
        return $this->languages;
    }

    function setLanguages(array $languages)
    {
        $this->languages = $languages;
    }

    function getHomeRoute()
    {
        return $this->homeRoute;
    }

    function setHomeRoute($homeRoute)
    {
        $this->homeRoute = $homeRoute;
    }
}
