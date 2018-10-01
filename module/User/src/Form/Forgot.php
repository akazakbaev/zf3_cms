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
use Core\Form\AbstractForm;

class Forgot extends Form
{
    public function __construct($name = null)
    {
        parent::__construct('forgot');

        $this->setAttribute('method', 'post');

        $this->addInputFilter();

        $this->addElements();

    }

    protected function addElements()
    {
        $this->add(array(
            'name' => 'email',
            'type' => 'Zend\Form\Element\Email',
            'attributes' => array(
                'id' => 'email',
                'placeholder' => 'example@gmail.com',
                'class' => 'form-control',
                'Please enter you email adress'
            ),
            'options' => array(
                'label' => 'Email',
            ),
        ));




        $this->add(array(
            'name' => 'forgot',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => array(
                'class' => 'btn',
                'id' => 'forgot',
                'type' => 'submit',
                'value' => 'forgot'
            ),
            'options' => array(
                'label' => 'Send Email',
            ),
        ));
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add input for "email" field
        $inputFilter->add([
            'name'     => 'email',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 128
                    ],
                ],
            ],
        ]);
    }
}