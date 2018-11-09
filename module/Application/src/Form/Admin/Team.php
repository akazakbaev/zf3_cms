<?php
/**
 * Created by PhpStorm.
 * @copyright (c) 2017 Core.kg
 * @author Azim Kazakbaev
 * Date: 4/3/17
 */

namespace Application\Form\Admin;

use User\Entity\UserUsers;
use User\Validator\UserNameExistsValidator;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use User\Validator\UserExistsValidator;
use User\Validator\PinExistsValidator;

class Team extends Form
{
    /**
     * Scenario ('create' or 'update').
     * @var string
     */
    private $scenario;


    public function __construct($scenario = 'create')
    {
        // Define form name
        parent::__construct($scenario);

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario      = $scenario;


        $this->addElements();
        $this->addInputFilter();
    }

    /**
     * This method adds elements to form (input fields and submit button).
     */
    protected function addElements()
    {
        // Add "email" field
        $this->add([
            'type'       => 'text',
            'name'       => 'pin',
            'options'    => [
                'label' => 'PIN',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label no-padding-right',
                ]
            ],
            'attributes' => [
                'class'     => 'form-control',
                'id'        => 'pin',
                'maxlength' => 14
            ],
        ]);


        $this->add([
            'name'       => 'photo',
            'type'       => 'Zend\Form\Element\File',
            'attributes' => [
                'type' => 'file',
                'id'   => 'user_photo_upload_form'
            ]
        ]);

        $this->add(array(
            'type' => 'Zend\Form\Element\Csrf',
            'name' => 'csrf',
        ));


        // Add the Submit button
        $this->add([
            'type'       => 'submit',
            'name'       => 'submit',
            'attributes' => [
                'value' => 'Save',
                'class' => 'btn btn-small btn-success',
            ],
        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add input for "pin" field
        $inputFilter->add([
            'name'       => 'pin',
            'required'   => true,
            'filters'    => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'max' => 14
                    ],
                ],
            ],
        ]);

    }
}