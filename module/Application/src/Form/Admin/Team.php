<?php
/**
 * Created by PhpStorm.
 * @copyright (c) 2017 Core.kg
 * @author Azim Kazakbaev
 * Date: 4/3/17
 */

namespace Application\Form\Admin;

use Application\Classes\AbstractLanguageForm;
use Application\Options\LanguageOptions;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class Team extends AbstractLanguageForm
{
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
                    'name'     => 'description',
                    'required' => true,
                    'filters'  => [
                        ['name' => 'StringTrim'],
                    ],
                ],
            ],
            'default' => [

            ]
        ];
    }
    public function __construct($scenario = 'create', $entityManager, LanguageOptions $languageOptions)
    {
        $this->setLanguageOptions($languageOptions);

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        $this->setHydrator(new DoctrineHydrator($entityManager));

        // Define form name
        parent::__construct($scenario);
    }
}