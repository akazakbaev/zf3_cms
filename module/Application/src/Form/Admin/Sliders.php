<?php
/**
 * About.kg
 *
 * @author azim
 * Date: 10/27/13
 * @license    http://www.about.kg/license/
 */
namespace Application\Form\Admin;

use Application\Classes\AbstractLanguageForm;
use Application\Entity\ApplicationSliders;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class Sliders extends AbstractLanguageForm
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
                        'class' => 'form-control ',
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
                    'name' => 'link',
                    'type' => 'Text',
                    'attributes' => [
                        'placeholder' => 'Link',
                        'class' => 'form-control'
                    ],
                    'options' => [
                        'label' => 'Link',
                        'label_attributes' => [
                            'class' => 'col-sm-3 control-label'
                        ],
                    ]
                ],
                [
                    'type' => 'Zend\Form\Element\Csrf',
                    'name' => 'csrf',
                ],
                [
                    'name' => 'status',
                    'type' => 'select',
                    'attributes' => [
                        'class' => 'form-control',
                    ],
                    'options' => [
                        'label' => 'Status',
                        'label_attributes' => [
                            'class' => 'col-sm-3 control-label'
                        ],
                        'value_options' => ApplicationSliders::STATUSES
                    ]
                ],
                [
                    'name'       => 'photo',
                    'type'       => 'Zend\Form\Element\File',
                    'attributes' => [
                        'type' => 'file',
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
            ],
            'default' => [
                [
                    'name'     => 'photo',
                    'type'     => 'Zend\InputFilter\FileInput',
                    'required' => ($this->scenario == 'create' ? true : false),
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
        $this->scenario = $scenario;

        $this->setLanguages($languages);

        parent::__construct($scenario);

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        $this->setHydrator(new DoctrineHydrator($entityManager));
    }
}