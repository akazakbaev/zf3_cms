<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\View\Helper;

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

        foreach ($form as $element) {
            if ($element instanceof FieldsetInterface) {
                $formContent .= $this->getView()->formCollection($element);
            } else {
                $input = $inputFilters->get($element->getName());

                $formContent .= $this->getView()->formRowDefault($element, null, null, null, $input->isRequired());
            }
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
