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

class Contacts extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        $this->add(array(
            'name' => 'portal_phone',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Phone number',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Phone number',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
            )
        ));

        $this->add(array(
            'name' => 'portal_address',
            'type' => 'Text',
            'attributes' => array(
                'placeholder' => 'Address',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Address',
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
            'name'     => 'portal_phone',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'portal_address',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
        ]);
    }
}