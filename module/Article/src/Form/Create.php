<?php
/**
 * About.kg
 *
 * @author azim
 * Date: 10/27/13
 * @license    http://www.about.kg/license/
 */
namespace Article\Form;

use Application\Classes\AbstractLanguageForm;
use Application\Options\LanguageOptions;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class Create extends AbstractLanguageForm
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
                    ],
                    'options' => [
                        'label' => 'Photo',
                        'label_attributes' => [
                            'class' => 'col-sm-3 control-label'
                        ],
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
                    'required' => $this->scenario == 'create' ? true : false,
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

        $this->scenario = $scenario;

        parent::__construct($scenario);

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        $this->setHydrator(new DoctrineHydrator($entityManager));
    }
}