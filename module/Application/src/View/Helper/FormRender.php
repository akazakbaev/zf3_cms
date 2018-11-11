<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\View\Helper;

use Application\Options\LanguageOptions;
use Application\Provider\FormTranslateInterface;
use Zend\Form\FieldsetInterface;
use Zend\Form\FormInterface;
use Zend\View\Helper\Doctype;
use Zend\Form\View\Helper\AbstractHelper;

/**
 * View helper for rendering Form objects
 */
class FormRender extends AbstractHelper
{
    /**
     * Attributes valid for this tag (form)
     *
     * @var array
     */
    protected $validTagAttributes = [
        'accept-charset' => true,
        'action'         => true,
        'autocomplete'   => true,
        'enctype'        => true,
        'method'         => true,
        'name'           => true,
        'novalidate'     => true,
        'target'         => true,
    ];

    protected $languageOptions;

    public function __construct(LanguageOptions $languageOptions)
    {
        $this->languageOptions = $languageOptions;
    }

    /**
     * Invoke as function
     *
     * @param  null|FormInterface $form
     * @return Form|string
     */
    public function __invoke(FormInterface $form = null)
    {
        if (! $form) {
            return $this;
        }

        return $this->render($form);
    }

    /**
     * Render a form from the provided $form,
     *
     * @param  FormInterface $form
     * @return string
     */
    public function render(FormInterface $form)
    {
        if (method_exists($form, 'prepare')) {
            $form->prepare();
        }

        $flashMessenger = $this->getView()->plugin('flashMessenger');

        $flashContent = '';

        $flashContent = $flashContent . $flashMessenger->setMessageOpenFormat('<div class="alert alert-danger"><p>')
            ->setMessageSeparatorString('</p><p>')
            ->setMessageCloseString('</p></div>')
            ->renderCurrent('error');

        $flashContent = $flashContent. $flashMessenger
                ->setMessageOpenFormat('<div class="alert alert-success"><p>')
                ->setMessageSeparatorString('</p><p>')
                ->setMessageCloseString('</p></div>')
                ->renderCurrent('success');

        $flashMessenger->getPluginFlashMessenger()->clearCurrentMessagesFromContainer();


        $formContent = '';

        $inputFilters = $form->getInputFilter();

        if(!$form instanceof FormTranslateInterface)
        {
            foreach ($form as $element)
            {
                if ($element instanceof FieldsetInterface) {
                    $formContent .= $this->getView()->formCollection($element);
                } else {
                    $input = $inputFilters->get($element->getName());

                    $formContent .= $this->getView()->formRowDefault($element, null, null, null, $input->isRequired());
                }
            }
        }
        else
        {


            $formContent .= '<ul class="nav nav-tabs">';

            $default = $this->languageOptions->getDefaultLocale();

            foreach ($this->languageOptions->getLanguages() as $key => $value)
            {
            $formContent .= '<li class=" '. ($default == $value ? 'active' : '') .'">
                    <a data-toggle="tab" href="#tab-'.$key.'" aria-expanded="true"><span class="lang-sm lang-lbl" lang="'. $key .'"></span> '. $value .'</a>
                </li>';
            }

            $formContent .= '</ul><div class="tab-content">';

            foreach ($this->languageOptions->getLanguages() as $key => $value)
            {
                $formContent .= '<div id="tab-'.$key.'" class="tab-pane '. ($default == $value ? 'active' : '') .'">
                    <div class="panel-body">';

                $formContent .= '';

                foreach ($form->getTranslateElements($key) as $element)
                {
                    if ($element instanceof FieldsetInterface) {
                        $formContent .= $this->getView()->formCollection($element);
                    } else {
                        $input = $inputFilters->get($element->getName());

                        $formContent .= $this->getView()->formRowDefault($element, null, null, null, $input->isRequired());
                    }
                }

                $formContent .= '</div></div>';
            }

            $formContent .= '<div> <hr>';

            foreach ($form->getDefaultElements() as $element)
            {
                if ($element instanceof FieldsetInterface) {
                    $formContent .= $this->getView()->formCollection($element);
                } else {
                    $input = $inputFilters->get($element->getName());

                    $formContent .= $this->getView()->formRowDefault($element, null, null, null, $input->isRequired());
                }
            }
            
            $formContent .= '</div></div>';
        }

        return $flashContent. $this->openTag($form) . $formContent . $this->closeTag();
    }

    /**
     * Generate an opening form tag
     *
     * @param  null|FormInterface $form
     * @return string
     */
    public function openTag(FormInterface $form = null)
    {
        $doctype    = $this->getDoctype();
        $attributes = [];

        if (! (Doctype::HTML5 === $doctype || Doctype::XHTML5 === $doctype)) {
            $attributes = [
                'action' => '',
                'method' => 'get',
            ];
        }

        if ($form instanceof FormInterface) {
            $formAttributes = $form->getAttributes();
            if (! array_key_exists('id', $formAttributes) && array_key_exists('name', $formAttributes)) {
                $formAttributes['id'] = $formAttributes['name'];
            }
            $attributes = array_merge($attributes, $formAttributes);
        }

        if ($attributes) {
            return sprintf('<form %s>', $this->createAttributesString($attributes));
        }

        return '<form>';
    }

    /**
     * Generate a closing form tag
     *
     * @return string
     */
    public function closeTag()
    {
        return '</form>';
    }
}
