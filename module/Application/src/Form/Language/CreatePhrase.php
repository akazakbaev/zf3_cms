<?php
/**
 * About.kg
 *
 * @author azim
 * Date: 10/27/13
 * @license    http://www.about.kg/license/
 */
namespace Application\Form\Language;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\Form\Element\Collection;

class CreatePhrase extends Form
{
    /**
     * @var $languageOption \Application\Options\LanguageOptions;
     */
    protected $languageOption;
    public function __construct($name = null, $languageOption)
    {
        parent::__construct($name);

        $this->languageOption = $languageOption;

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        $this->addElements();
        $this->addInputFilter();
    }

    protected function addElements()
    {
        $this->add(array(
            'name' => 'key',
            'type' => 'Text',
            'attributes' => array(
                'type' => 'textarea',
                'placeholder' => 'phrase',
                'class' => 'form-control',
            ),
            'options' => array(
                'label' => 'Key',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label no-padding-right',
                ]
            )
        ));


        $languages = $this->languageOption->getLanguages();

        foreach ($languages as $language)
        {
            $this->add(array(
                'name'     => $language,
                'attributes' => array(
                    'type' => 'textarea',
                    'placeholder' => 'phrase',
                    'class' => 'form-control',
                ),
                'options' => array(
                    'label' => $language,
                    'label_attributes' => [
                        'class' => 'col-sm-3 control-label',
                    ]
                )
            ));
        }

        $this->add([
            'name' => 'js',
            'type' => 'checkbox',
            'attributes' => [
//                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'JS?',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label',
                ],
                'value_options' => array(
                    '1' => 'Js?',
                ),
            ]
        ]);

        // Add the Submit button
        $this->add(array(
            'name' => 'send',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => array(
                'class' => 'btn btn-small btn-success',
                'type' => 'submit',
                'value' => 'Save'
            ),
            'options' => array(
                'label' => 'Save',
            ),
        ));
    }

    public function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $languages = $this->languageOption->getLanguages();

        foreach ($languages as $language)
        {
            $inputFilter->add([
                'name'     => $language,
                'required' => true,
                'filters'  => [
                    ['name' => 'StringTrim'],
                ],
            ]);
        }

        $inputFilter->add([
            'name'     => 'key',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
        ]);
    }
}