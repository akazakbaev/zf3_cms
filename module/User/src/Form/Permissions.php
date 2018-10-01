<?php
/**
 * Offer create form
 * 
 * @copyright (c) 2013, Azbe.net
 * @author Berdimurat Masaliev <muratmbt@gmail.com>
 */

namespace User\Form;

use Zend\Form\Form;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class Permissions extends Form
{
    public function __construct($name = null, $options = array())
    {
        parent::__construct($name, $options);

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        $this->add(array(
            'name' => 'level_id',
            'type' => 'select',
            'attributes' => array(
                'id' => 'level_id',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Levels:',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
            ),
        ));

        $this->add([
            'name' => 'permissions',
            'type' => 'multicheckbox',
            'attributes' => array(
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Persmissions',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
            ),
        ]);
        
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
            'name'     => 'level_id',
            'required' => true
        ]);

    }
}
?>
