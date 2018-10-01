<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev
 * Date: 6/27/17
 * Time: 11:42 AM
 */
namespace User\Form;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use User\Validator\UserExistsValidator;

class Edit extends Form
{
    public $user = null;


    public function __construct($scenario = null, $options = array())
    {
        parent::__construct($scenario, $options);

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        $this->user = $options['user'];

        // Save parameters for internal use.
        $this->scenario = $scenario;


        $this->addElements();
        $this->addInputFilter();
    }

    public function addElements()
    {
        // Add "email" field
            $this->add([
                'type'  => 'text',
                'name' => 'email',
                'options' => [
                    'label' => 'E-mail',
                    'label_attributes' => [
                        'class' => 'col-sm-3 control-label'
                    ]
                ],
                'attributes' => [
                    'class' => 'form-control',
                    'id' => 'email'
                ],
            ]);

        // Add "password" field
        $this->add([
            'type'  => 'password',
            'name' => 'old_password',
            'options' => [
                'label' => 'Old Password',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ]
            ],
            'attributes' => [
                'class' => 'form-control',
                'id' => 'password'
            ]
        ]);

        // Add "password" field
        $this->add([
            'type'  => 'password',
            'name' => 'new_password',
            'options' => [
                'label' => 'New Password',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ]
            ],
            'attributes' => [
                'class' => 'form-control',
                'id' => 'password'
            ]
        ]);

        // Add "confirm_password" field
        $this->add([
            'type'  => 'password',
            'name' => 'confirm_password',
            'options' => [
                'label' => 'Confirm password',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ]
            ],
            'attributes' => [
                'class' => 'form-control',
            ]
        ]);

        // Add the Submit button
        $this->add([
            'type' => 'Button',
            'name' => 'submit',
            'options' => array(
                'label'   => 'Save',
            ),
            'attributes' => array(
                'type'  => 'submit',
                'class' => 'btn btn-primary'
            )
        ]);
    }

    public function addInputFilter()
    {
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name'     => 'old_password',
            'required' => true,
            'filters'  => [
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 64
                    ],
                ],
            ],
        ]);

        // Add input for "new_password" field
        $inputFilter->add([
            'name'     => 'new_password',
            'required' => true,
            'filters'  => [
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 64
                    ],
                ],
            ],
        ]);

        // Add input for "confirm_new_password" field
        $inputFilter->add([
            'name'     => 'confirm_password',
            'required' => true,
            'filters'  => [
            ],
            'validators' => [
                [
                    'name'    => 'Identical',
                    'options' => [
                        'token' => 'new_password',
                    ],
                ],
            ],
        ]);

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
                [
                    'name' => 'EmailAddress',
                    'options' => [
                        'allow' => \Zend\Validator\Hostname::ALLOW_DNS,
                        'useMxCheck'    => false,
                    ],
                ],
                [
                    'name' => UserExistsValidator::class,
                    'options' => [
                        'user' => $this->user
                    ],
                ],
            ],
        ]);
    }
}