<?php
/**
 * Created by PhpStorm.
 * @copyright (c) 2017 Core.kg
 * @author Azim Kazakbaev
 * Date: 4/3/17
 */

namespace User\Form;
use Zend\Form\Form;
use Zend\Form\Fieldset;
use Zend\InputFilter\InputFilter;
use User\Validator\UserExistsValidator;
use Core\Form\AbstractForm;
use User\Validator\PinExistsValidator;

class Signup extends Form
{
    /**
     * Scenario ('create' or 'update').
     * @var string
     */
    private $scenario;


    private $user = null;


    /**
     * Constructor.
     */

    public function __construct($scenario = 'create', $user = null)
    {

        // Define form name
        parent::__construct('user-form');

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario = $scenario;
        $this->user = $user;

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
            'type'  => 'text',
            'name' => 'pin',
            'options' => [
                'label' => 'PIN',
            ],
            'attributes' => [
                'class' => 'form-control',
                'maxlength' => 14
            ],
        ]);

        // Add "full_name" field
        $this->add([
            'type'  => 'text',
            'name' => 'title',
            'options' => [
                'label' => 'FIO',
            ],
            'attributes' => [
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'type'  => 'date',
            'name' => 'birthdate',
            'options' => [
                'label' => 'Birth Date',
            ],
            'attributes' => [
                'class' => 'form-control',
                'format' => 'dd-MM-yyyy'
            ]
        ]);

        $this->get('birthdate')->setOptions(array('format'=>'Y-m-d'));

        $this->add([
            'type'  => 'text',
            'name' => 'passport_number',
            'options' => [
                'label' => 'Passport Number',
            ],
            'attributes' => [
                'class' => 'form-control',
            ]
        ]);

        // Add "password" field
        $this->add([
            'type'  => 'password',
            'name' => 'password',
            'options' => [
                'label' => 'Password',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Password'
            ],
        ]);

        $this->add([
            'type'  => 'password',
            'name' => 'confirm_password',
            'options' => [
                'label' => 'Confirm Password',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Password'
            ],
        ]);

        $this->add([
            'type' => 'select',
            'name' => 'category',
            'options' => [
                'label' => 'Listener Category',
                'value_options' => \User\Model\User::getCategories(),
                'empty_option' => 'Choose category',

                'label_attributes' => [
//                    'class' => 'col-sm-3 control-label no-padding-right'
                    'required' => true,
                ]
            ],
            'attributes' => [
                'class' => 'form-control',
            ]
        ]);

        $this->add([
            'type'  => 'text',
            'name' => 'position_text',
            'options' => [
                'label' => 'Position',
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        // Add "email" field
        $this->add([
            'type'  => 'text',
            'name' => 'email',
            'options' => [
                'label' => 'Email Address',
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'E-mail'
            ],

        ]);

        $this->add([
            'name' => 'file',
            'type' => 'Zend\Form\Element\File',
            'attributes' => [
                'type' => 'file'
            ],
            'options' => [
                'label' => 'Scanning of supporting documents',
            ]
        ]);

        // Add the Submit button
//        $this->add([
//            'type'  => 'submit',
//            'name' => 'send',
//            'attributes' => [
//                'value' => 'Login'
//            ],
//            'options' => [
//                'label' => 'Scanning of supporting documents',
//            ]
//        ]);
    }

    /**
     * This method creates input filter (used for form filtering/validation).
     */
    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name'     => 'pin',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'max' => 14
                    ],
                ],
                [
                    'name' => PinExistsValidator::class,
                    'options' => [
                        'user' => $this->user
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'title',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 10,
                        'max' => 255
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'position_text',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 255
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'passport_number',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 3,
                        'max' => 10
                    ],
                ],
            ],
        ]);

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


        // Add input for "password" field
        $inputFilter->add([
            'name'     => 'password',
            'required' => true,
            'filters'  => [
            ],
            'validators' => [
//                [
//                    'name' => 'NotEmpty'
//                ],
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 64,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => "The input is less than 6 characters long",
                        )
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'confirm_password',
            'required' => true,
            'filters'  => [
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 6,
                        'max' => 64,
                        'messages' => array(
                            \Zend\Validator\StringLength::TOO_SHORT => "The input is less than 6 characters long",
                        )
                    ],
                ],
                [
                    'name' => 'identical',
                    'options' => [
                        'token' => 'password',
                        'messages' => [
                            \Zend\Validator\Identical::NOT_SAME => "The two given passwords do not match",
                            \Zend\Validator\Identical::MISSING_TOKEN => 'No password was provided to match against',
                        ]
                    ]
                ]
            ],
        ]);

        $inputFilter->add([
            'name'     => 'file',
            'required' => true,
            'validators' => [
                ['name'    => 'FileUploadFile'],
//                [
//                    'name'    => 'FileMimeType',
//                    'options' => [
//                        'mimeType'  => ['image/jpeg', 'image/png']
//                    ]
//                ],
                ['name'    => 'FileIsImage'],
                [
                    'name'    => 'FileImageSize',
                    'options' => [
                        'minWidth'  => 128,
                        'minHeight' => 128,
                        'maxWidth'  => 4096,
                        'maxHeight' => 4096
                    ]
                ],

            ]
        ]);
    }
}