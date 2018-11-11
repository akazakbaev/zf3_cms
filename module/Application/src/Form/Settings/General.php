<?php
/**
 * About.kg
 *
 * @author azim
 * Date: 10/27/13
 * @license    http://www.about.kg/license/
 */
namespace Application\Form\Settings;

use Zend\Form\Form;
use Zend\InputFilter\InputFilter;

class General extends Form
{
    private $prefix;

    public function __construct($name = null, $prefix = '', $languageOption)
    {
        parent::__construct($name);

        $this->prefix = $prefix;

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));


        $languages = $languageOption->getLanguages();

        $this->add([
            'name' => 'language',
            'type' => 'select',
            'attributes' => [
                'class' => 'form-control',
                'id' => 'lang'
            ],
            'options' => [
                'label' => 'Choose Language',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
                'value_options' => $languages
            ]
        ]);

        $this->add(array(
            'name' => 'site_title'.$this->prefix,
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Site title in russian',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Site Title',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
            )
        ));


        $this->add(array(
            'name' => 'site_description'.$this->prefix,
            'type' => 'Textarea',
            'attributes' => array(
                'placeholder' => 'This data can be used by search engines to compile a brief description of the page in the results list.',
                'class' => 'form-control',
            ),
            'options' =>  array(
                'label' => 'Site Description',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
            )
        ));

        $this->add(array(
            'name' => 'site_keywords'.$this->prefix,
            'type' => 'Textarea',
            'attributes' => array(
                'placeholder' => 'keywords - the words on which the advance position of sites in search engines',
                'class' => 'form-control',
            ),
            'options' =>  array(
                'label' => 'Site Keywords',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
            )
        ));


        // Buttons
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

        $this->addInputFilter();
    }

    public function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name'     => 'site_title'.$this->prefix,
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'site_description'.$this->prefix,
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'site_keywords'.$this->prefix,
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
        ]);
    }
}