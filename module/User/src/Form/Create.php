<?php
/**
 * Created by PhpStorm.
 * @copyright (c) 2017 Core.kg
 * @author Azim Kazakbaev
 * Date: 4/3/17
 */

namespace User\Form;

use User\Entity\UserUsers;
use User\Validator\UserNameExistsValidator;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use User\Validator\UserExistsValidator;
use User\Validator\PinExistsValidator;
/**
 * This form is used to collect user's email, full name, password and status. The form
 * can work in two scenarios - 'create' and 'update'. In 'create' scenario, user
 * enters password, in 'update' scenario he/she doesn't enter password.
 */
class Create extends Form
{
    /**
     * Scenario ('create' or 'update').
     * @var string
     */
    private $scenario;


    /**
     * Current user.
     * @var \User\Entity\UserUsers
     */
    private $user = null;


    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager = null;

    /**
     * Constructor.
     */
    public function __construct($scenario = 'create', $entityManager = null, $user = null)
    {
        // Define form name
        parent::__construct('user-form');

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        // Set POST method for this form
        $this->setAttribute('method', 'post');

        // Save parameters for internal use.
        $this->scenario      = $scenario;
        $this->user          = $user;
        $this->entityManager = $entityManager;


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
                'label' => 'PIN'
            ],
            'attributes' => [
                'class'     => 'form-control',
                'id'        => 'pin',
                'maxlength' => 14
            ],
        ]);

        if ($this->scenario == 'edit') {
            $this->get('pin')->setAttribute('readOnly', true);
        }

        $this->add([
            'type'       => 'text',
            'name'       => 'username',
            'options'    => [
                'label' => 'Username'
            ],
            'attributes' => [
                'class' => 'form-control',
            ],
        ]);

        $this->add([
            'type'       => 'text',
            'name'       => 'fname',
            'options'    => [
                'label' => 'First Name',
            ],
            'attributes' => [
                'class'    => 'form-control',
                'readOnly' => true,
                'id'       => 'name'
            ]
        ]);

        $this->add([
            'type'       => 'text',
            'name'       => 'lname',
            'options'    => [
                'label' => 'Last Name',
            ],
            'attributes' => [
                'class'    => 'form-control',
                'readOnly' => true,
                'id'       => 'surname'
            ]
        ]);

        $this->add([
            'type'       => 'text',
            'name'       => 'pname',
            'options'    => [
                'label' => 'Patronymic',
            ],
            'attributes' => [
                'class'    => 'form-control',
                'readOnly' => true,
                'id'       => 'patronymic'
            ]
        ]);

        $this->add([
            'type'       => 'text',
            'name'       => 'bdate',
            'options'    => [
                'label' => 'Birthdate',
            ],
            'attributes' => [
                'class'    => 'form-control',
                'readOnly' => true,
                'id'       => 'dateOfBirth'
            ]
        ]);

        $this->get('bdate')->setOptions(array('format' => 'Y-m-d'));

        // Add "email" field
        $this->add([
            'type'       => 'text',
            'name'       => 'email',
            'options'    => [
                'label' => 'E-mail'
            ],
            'attributes' => [
                'class' => 'form-control',
                'id'    => 'email',
            ],
        ]);

        // Add "password" field
        $this->add([
            'type'       => 'text',
            'name'       => 'password',
            'options'    => [
                'label' => 'Password',
            ],
            'attributes' => [
                'class' => 'form-control',
                'id'    => 'password'
            ]
        ]);


        $this->add([
            'type'       => 'select',
            'name'       => 'status',
            'options'    => [
                'label'         => 'Status',
                'value_options' => [
                    UserUsers::STATUS_DISABLED => 'Disabled',
                    UserUsers::STATUS_ENABLED  => 'Enabled',
                ]
            ],
            'attributes' => [
                'class' => 'form-control',
            ]
        ]);


        $this->add([
            'type'       => 'select',
            'name'       => 'level_id',
            'options'    => [
                'label' => 'Level'
            ],
            'attributes' => [
                'class' => 'form-control',
            ]
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
                [
                    'name'    => PinExistsValidator::class,
                    'options' => [
                        'entityManager' => $this->entityManager,
                        'user'          => $this->user
                    ],
                ],
            ],
        ]);

        // Add input for "pin" field
        $inputFilter->add([
            'name'       => 'username',
            'required'   => true,
            'filters'    => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => UserNameExistsValidator::class,
                    'options' => [
                        'entityManager' => $this->entityManager,
                        'user'          => $this->user
                    ],
                ],
            ],
        ]);

        // Add input for "email" field
        $inputFilter->add([
            'name'       => 'email',
            'required'   => true,
            'filters'    => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 1,
                        'max' => 254
                    ],
                ],
                [
                    'name'    => 'EmailAddress',
                    'options' => [
                        'allow'      => \Zend\Validator\Hostname::ALLOW_DNS,
                        'useMxCheck' => false,
                    ],
                ],
                [
                    'name'    => UserExistsValidator::class,
                    'options' => [
                        'entityManager' => $this->entityManager,
                        'user'          => $this->user
                    ],
                ],
            ],
        ]);

        // Add input for "full_name" field
        $inputFilter->add([
            'name'       => 'fname',
            'required'   => true,
            'filters'    => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 2,
                        'max' => 100
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name'       => 'lname',
            'required'   => true,
            'filters'    => [
                ['name' => 'StringTrim'],
            ],
            'validators' => [
                [
                    'name'    => 'StringLength',
                    'options' => [
                        'min' => 2,
                        'max' => 100
                    ],
                ],
            ],
        ]);

        $inputFilter->add([
            'name' => 'bdate',
            'required' => true,
            'filters' => [
                ['name' => 'StringTrim'],
            ]
        ]);


        if ($this->scenario == 'create') {

            // Add input for "password" field
            $inputFilter->add([
                'name'       => 'password',
                'required'   => true,
                'filters'    => [
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

            $inputFilter->add([
                'name'       => 'photo',
                'required'   => false,
                'validators' => [
                    ['name' => 'FileUploadFile'],
                    ['name' => 'FileIsImage'],
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

        // Add input for "status" field
        $inputFilter->add([
            'name'       => 'status',
            'required'   => true,
            'filters'    => [
                ['name' => 'ToInt'],
            ],
            'validators' => [
                ['name' => 'InArray', 'options' => ['haystack' => [UserUsers::STATUS_ENABLED, UserUsers::STATUS_DISABLED]]]
            ],
        ]);
    }

    public function setData($data)
    {
        if (empty($data['photo']['tmp_name']))
            unset($data['photo']);
        return parent::setData($data); // TODO: Change the autogenerated stub
    }

    public function populateValues($data, $onlyBase = false)
    {
        if(is_array($data['bdate'])){
            $data['bdate'] = (new \DateTime($data['bdate']['date']))->format("Y-m-d");
        }
        parent::populateValues($data, $onlyBase); // TODO: Change the autogenerated stub
    }

}