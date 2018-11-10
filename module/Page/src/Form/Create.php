<?php
/**
 * About.kg
 *
 * @author azim
 * Date: 10/27/13
 * @license    http://www.about.kg/license/
 */
namespace Page\Form;

use Application\Options\LanguageOptions;
use Zend\Form\Form;
use Zend\InputFilter\InputFilter;
use DoctrineModule\Stdlib\Hydrator\DoctrineObject as DoctrineHydrator;

class Create extends Form
{
    public function __construct($name = null, $entityManager, LanguageOptions $languageOptions)
    {
        parent::__construct($name);

        $this->setAttributes(array('method' => 'post', 'class' => 'form-horizontal'));

        $this->setHydrator(new DoctrineHydrator($entityManager));

        $languages = $languageOptions->getLanguages();

        foreach ($languages as $language) {

            $this->add(array(
                'name' => 'title'.$language,
                'type' => 'Text',
                'attributes' => array(
                    'placeholder' => 'Title in russian',
                    'class' => 'form-control'
                ),
                'options' => array(
                    'label' => 'Title in russian',
                    'label_attributes' => [
                        'class' => 'col-sm-3 control-label'
                    ],
                )
            ));

            $this->add(array(
                'name' => 'description'.$language,
                'type' => 'Textarea',
                'attributes' => array(
                    'placeholder' => 'Description in russian',
                    'class' => 'form-control summernote',
                ),
                'options' => array(
                    'label' => 'Description in russian',
                    'label_attributes' => [
                        'class' => 'col-sm-3 control-label'
                    ],
                )
            ));
        }

        // Buttons
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

            ],
        ]);

        $inputFilter->add([
            'name'     => 'titleKg',
            'required' => true,
            'filters'  => [

            ],
        ]);

        $inputFilter->add([
            'name'     => 'bodyKg',
            'required' => true,
            'filters'  => [

            ],
        ]);

    }
}