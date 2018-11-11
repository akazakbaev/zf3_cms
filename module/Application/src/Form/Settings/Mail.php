<?php
/**
 * About.kg
 *
 * @author azim
 * Date: 10/27/13
 * @license    http://www.about.kg/license/
 */
namespace Application\Form\Settings;

use Zend\Form\Form;
use Zend\Form\Element;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;

class Mail extends Form
{
    public function __construct($name = null)
    {
        parent::__construct($name);

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));
        
        $this->add(array(
            'name' => 'mail_from',
            'type' => 'Text',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Contact From',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Contact From',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ]
            )
        ));

        $this->add(array(
            'name' => 'mail_contact',
            'type' => 'Text',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Contact Form Email',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Contact Form Email',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ]
            )
        ));

        $this->add([
            'name' => 'mail_smtp_send',
            'type' => 'select',
            'attributes' => [
                'class' => 'form-control'
            ],
            'options' => [
                'label' => 'Send by SMTP',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
                'value_options' => array(
                    '0' => 'Использовать встроенную почтовую функцию',
                    '1' => 'Отправить электронную почту через сервер SMTP',
                ),
            ]
        ]);

        $this->add(array(
            'name' => 'mail_smtp_host',
            'type' => 'Text',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Host',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Host',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ]
            )
        ));
        $this->add(array(
            'name' => 'mail_smtp_port',
            'type' => 'Text',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'Port',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'Port',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ]
            )
        ));

        $this->add(array(
            'name' => 'mail_smtp_ssl',
            'type' => 'select',
            'attributes' => [
                'class' => 'form-control'
            ],
            'options' => array(
                'value_options' => array(
                    'ssl' => 'ssl',
                    'tls' => 'tls',
                ),
                'label' => 'ssl',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ]
            )
        ));

        $this->add([
            'name' => 'mail_smtp_authentication',
            'type' => 'radio',
            'attributes' => [
//                'class' => 'ace'
            ],
            'options' => [
                'label' => 'Аутентификация SMTP?',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ],
                'value_options' => array(
                    '1' => 'YES',
                    '0' => 'NO',
                ),
            ]
        ]);

        
        $this->add(array(
            'name' => 'mail_smtp_username',
            'type' => 'Text',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'SMTP login',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'SMTP login',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ]
            )
        ));



        $this->add(array(
            'name' => 'mail_smtp_password',
            'type' => 'password',
            'attributes' => array(
                'type' => 'text',
                'placeholder' => 'SMTP password',
                'class' => 'form-control'
            ),
            'options' => array(
                'label' => 'SMTP password',
                'label_attributes' => [
                    'class' => 'col-sm-3 control-label'
                ]
            )
        ));


        // Add the Submit button
        $this->add(array(
            'name' => 'send',
            'type' => 'Zend\Form\Element\Button',
            'attributes' => array(
                'class' => 'btn btn-small btn-success',
                'type' => 'submit',
                'value' => 'Save'
            ),
            'options' => array(
                'label' => 'Save',
            ),
        ));

        $this->addInputFilter();
    }

    public function addInputFilter()
    {
        // Create main input filter
        $inputFilter = new InputFilter();
        $this->setInputFilter($inputFilter);
    }
}