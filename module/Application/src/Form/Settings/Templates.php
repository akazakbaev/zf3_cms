<?php
/**
 * Offer create form
 * 
 * @copyright (c) 2013, Azbe.net
 * @author Berdimurat Masaliev <muratmbt@gmail.com>
 */

namespace Application\Form\Settings;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class Templates extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        $this->add(array(
            'name' => 'mailtemplate_id',
            'type' => 'select',
            'attributes' => array(
                'id' => 'mailtemplate_id',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Templates',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
            ),
        ));

        $this->add(array(
            'name' => 'title',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Title',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Title',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
            ),
        ));

        
        $this->add(array(
            'name' => 'body',
            'attributes' => array(
                'type' => 'textarea',
                'placeholder' => 'Description',
                'class' => 'summernote form-control',
                'style' => 'min-height: 150px;'
            ),
            'options' => array(
                'label' => 'Description',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
            ),
        ));
        
        // Buttons
        $this->add(array(
            'name' => 'send',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => array(
                'class' => 'btn btn-small btn-success',
                'type' => 'submit',
                'value' => 'Сохранить'
            ),
            'options' => array(
                'label' => 'Сохранить',
            ),
        ));

        $this->addInputFilter();
    }

    public function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);

        $inputFilter->add([
            'name'     => 'mailtemplate_id',
            'required' => true
        ]);

        $inputFilter->add([
            'name'     => 'title',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
        ]);

        $inputFilter->add([
            'name'     => 'body',
            'required' => true,
            'filters'  => [
                ['name' => 'StringTrim'],
            ],
        ]);
    }
}
?>
