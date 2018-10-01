<?php
/**
 * Login Form
 * @copyright (c) 2013, Azbe.net
 * @author Berdimurat Masaliev <muratmbt@gmail.com>
 */

namespace User\Form;
use Zend\Form\Form;
use Core\Api\Api;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class Photo extends Form
{

    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setAttribute('id', 'user_photo_upload_form');
        $this->setAttribute('enctype', 'multipart/form-data');

        $this->setAttribute('method', 'post');

        $this->add(array(
            'name' => 'photo',
            'type' => 'Zend\Form\Element\File',
            'attributes' => array(
                'type' => 'file',
                'id' => 'userPhotoFile'
            ),
            'options' => array(
                'label' => 'Photo'
            )
        ));

        // Buttons
        $this->add(array(
            'name' => 'send',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => array(
                'class' => 'btn btn-small btn-success',
                'type' => 'submit',
                'value' => 'Create'
            ),
            'options' => array(
                'label' => 'Create',
            ),
        ));

        $this->addInputFilter();
    }

    private function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        // Add input for "email" field
        $inputFilter->add([
            'name'     => 'photo',
            'required' => true,
            'validators' => [
                ['name'    => 'FileUploadFile'],
                [
                    'name'    => 'FileMimeType',
                    'options' => [
                        'mimeType'  => ['image/jpeg', 'image/png']
                    ]
                ],
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

            ],
            'filters'  => [
                [
                    'name' => 'FileRenameUpload',
                    'options' => [
                        'target'=>'./data/upload',
                        'useUploadName'=>true,
                        'useUploadExtension'=>true,
                        'overwrite'=>true,
                        'randomize'=>false
                    ]
                ]
            ],
        ]);
    }
}
?>
