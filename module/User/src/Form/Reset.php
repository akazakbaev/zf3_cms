<?php
/**
 * Created by JetBrains PhpStorm.
 * User: azim
 * Date: 9/6/13
 * Time: 2:46 PM
 * To change this template use File | Settings | File Templates.
 */

namespace User\Form;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class Reset extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('reset');

        $this->setAttribute('method', 'post');

        $this->addInputFilter();

        $this->addElements();
    }

    protected function addElements()
    {
        $this->add(array(
            'name' => 'password',
            'attributes' => array(
                'id' => 'password',
                'type' => 'password',
                'placeholder' => 'Password',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Password',
            ),
        ));

        $this->add(array(
            'name' => 'confirm_pass',
            'attributes' => array(
                'id' => 'conform_pass',
                'type' => 'password',
                'placeholder' => 'Confirm Password',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Confirm Password',
            ),
        ));

        // Buttons
        $this->add(array(
            'name' => 'reset',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Reset'
            ),
            'options' => array(
                'label' => 'Reset',
            ),
        ));
    }

    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name' => 'password',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty'
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 5,
                    ),
                ),
            ),
        ]);

        $inputFilter->add(array(
            'name' => 'confirm_pass',
            'required' => true,
            'validators' => array(
                array(
                    'name' => 'NotEmpty'
                ),
                array(
                    'name' => 'StringLength',
                    'options' => array(
                        'min' => 5,
                    ),
                ),
                array(
                    'name' => 'identical',
                    'options' => array(
                        'token' => 'password',
                        'messages' => array(
                            \Zend\Validator\Identical::NOT_SAME => "The two given passwords do not match",
                            \Zend\Validator\Identical::MISSING_TOKEN => 'No password was provided to match against',
                        )
                    ),
                ),
            ),
        ));
    }
}