<?php
/**
 * Created by PhpStorm.
 * @copyright (c) 2017 Core.kg
 * @author Azim Kazakbaev
 * Date: 4/3/17
 */

namespace Application\Form\Admin;

use Application\Classes\AbstractLanguageForm;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class Team extends AbstractLanguageForm
{
    protected $scenario;

    public function getArrayElements()
    {
        return [
            'translate' => [
                [
                    'name' => 'title',
                    'type' => 'Text',
                    'attributes' => [
                        'placeholder' => 'Title',
                        'class' => 'form-control'
                    ],
                    'options' => [
                        'label' => 'Title',
                        'label_attributes' => [
                            'class' => 'col-sm-3 control-label'
                        ],
                    ]
                ],
                [
                    'name' => 'shortDescription',
                    'type' => 'Textarea',
                    'attributes' => [
                        'placeholder' => 'Short Description',
                        'class' => 'form-control',
                    ],
                    'options' => [
                        'label' => 'Short Description',
                        'label_attributes' => [
                            'class' => 'col-sm-3 control-label'
                        ],
                    ]
                ],
                [
                    'name' => 'description',
                    'type' => 'Textarea',
                    'attributes' => [
                        'placeholder' => 'Description',
                        'class' => 'form-control summernote',
                    ],
                    'options' => [
                        'label' => 'Description',
                        'label_attributes' => [
                            'class' => 'col-sm-3 control-label'
                        ],
                    ]
                ]
            ],
            'default' => [
                [
                    'name'       => 'photo',
                    'type'       => 'Zend\Form\Element\File',
                    'attributes' => [
                        'type' => 'file',
                        'id'   => 'user_photo_upload_form'
                    ]
                ],
                [
                    'name' => 'send',
                    'type' => 'Zend\Form\Element\Button',
                    'attributes' => [
                        'class' => 'btn btn-small btn-success',
                        'type' => 'submit',
                        'value' => 'Save'
                    ],
                    'options' => [
                        'label' => 'Save',
                    ]
                ]
            ]
        ];
    }

    public function getArrayInputFilters()
    {
        return [
            'translate' => [
                [
                    'name'     => 'title',
                    'required' => true,
                    'filters'  => [
                        ['name' => 'StringTrim'],
                    ],
                ],
                [
                    'name'     => 'shortDescription',
                    'required' => true,
                    'filters'  => [
                        ['name' => 'StringTrim'],
                    ],
                ],
            ],
            'default' => [
                [
                    'name'     => 'photo',
                    'type'     => 'Zend\InputFilter\FileInput',
                    'required' => ($this->scenario === 'create' ? true : false),
                    'validators' => [
                        ['name'    => 'FileUploadFile'],
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
                ]
            ]
        ];
    }

    public function __construct($scenario = null, $entityManager, array $languages)
    {
        $this->setLanguages($languages);

        // Define form name
        parent::__construct($scenario);

        $this->scenario = $scenario;

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        $this->setHydrator(new DoctrineHydrator($entityManager));
    }
}