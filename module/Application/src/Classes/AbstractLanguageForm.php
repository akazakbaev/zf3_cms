<?php
/**
 * About.kg
 *
 * @author azim
 * Date: 10/27/13
 * @license    http://www.about.kg/license/
 */
namespace Application\Classes;

use Application\Options\LanguageOptions;
use Application\Provider\FormTranslateInterface;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

abstract class AbstractLanguageForm extends Form implements FormTranslateInterface
{
    /**
     * @var array
     */
    protected $languages;

    protected $entityManager;

    protected $scenario;

    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->scenario = $name;

        $this->addDefaultElements();
        $this->addTranslateElements();

        $this->addInputFilter();
    }

    public function setLanguages(array $languages)
    {
        $this->languages = $languages;
    }

    public function getLanguages()
    {
        return $this->languages;
    }

    public function addDefaultElements()
    {
        $allElements = $this->getArrayElements();

        $defaultElements = $allElements['default'] ?? [];

        foreach ($defaultElements as $element)
        {
            $this->add($element);
        }
    }

    public function addTranslateElements()
    {
        $allElements = $this->getArrayElements();

        $translateElements = $allElements['translate'] ?? [];

        foreach ($this->getLanguages() as $key => $language)
        {
            foreach ($translateElements as $element)
            {
                $element['name'] = $element['name'].ucfirst($key);
                $this->add($element);
            }
        }

    }

    public function getTranslateElements($lang)
    {
        $allElements = $this->getArrayElements();

        $elements = $allElements['translate'] ?? [];

        $elementsData = [];

        foreach ($elements as $element)
        {
            if($this->has($element['name'].ucfirst($lang)))
                $elementsData[] = $this->get($element['name'].ucfirst($lang));
        }

        return $elementsData;
    }

    public function getDefaultElements()
    {
        $allElements = $this->getArrayElements();

        $elements = $allElements['default'] ?? [];

        $elementsData = [];

        foreach ($elements as $element)
        {
            if($this->has($element['name']))
                $elementsData[] = $this->get($element['name']);
        }

        return $elementsData;
    }

    public function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);


        $allInputFiltersElements = $this->getArrayInputFilters();

        $translateElements = $allInputFiltersElements['translate'] ?? [];

        foreach ($this->getLanguages() as $key => $language)
        {
            foreach ($translateElements as $element)
            {
                $element['name'] = $element['name'].ucfirst($key);
                $inputFilter->add($element);
            }
        }

        $defaultInputFiltersElement =  $allInputFiltersElements['default'] ?? [];

        foreach ($defaultInputFiltersElement as $element)
        {
            $inputFilter->add($element);
        }
    }
}