<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/zf2 for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\View\Helper;

use Zend\Form\Element\Button;
use Zend\Form\Element\Date;
use Zend\Form\Element\Textarea;
use Zend\Form\Element\MonthSelect;
use Zend\Form\Element\Captcha;
use Zend\Form\ElementInterface;
use Zend\Form\Exception;
use Zend\Form\LabelAwareInterface;
use Zend\Form\View\Helper\AbstractHelper;
use Zend\Form\View\Helper\FormLabel;
use Zend\Form\View\Helper\FormElement;
use Zend\Form\View\Helper\FormElementErrors;

class FormRowDefault extends AbstractHelper
{
    const FORM_ROW_CONFIG_KEY = 'form_row_config';
    const FORM_ROW_CONFIG = array(
        'elementRowOpen',
        'labelOpen ',
        'label ',
        'labelClose',
        'elementContainerOpen',
        'elementString',
        'elementIcon',
        'elementDescriptionContainerOpen',
        'elementDescription',
        'elementDescriptionContainerClose',
        'elementContainerClose',
        'elementErrorsContainerOpen',
        'elementErrors',
        'elementErrorsContainerClose',
        'elementLink',
        'elementRowClose',
        'elementNoLabelContainerOpen',
        'elementNoLabelContainerClose',
    );
    const LABEL_APPEND  = 'append';
    const LABEL_PREPEND = 'prepend';

    /**
     * The class that is added to element that have errors
     *
     * @var string
     */
    protected $inputErrorClass = 'input-error';

    /**
     * The attributes for the row label
     *
     * @var array
     */
    protected $labelAttributes;

    /**
     * Where will be label rendered?
     *
     * @var string
     */
    protected $labelPosition = self::LABEL_PREPEND;

    /**
     * Are the errors are rendered by this helper?
     *
     * @var bool
     */
    protected $renderErrors = true;

    /**
     * Form label helper instance
     *
     * @var FormLabel
     */
    protected $labelHelper;

    /**
     * Form element helper instance
     *
     * @var FormElement
     */
    protected $elementHelper;

    /**
     * Form element errors helper instance
     *
     * @var FormElementErrors
     */
    protected $elementErrorsHelper;

    /**
     * @var string
     */
    protected $partial;


    /**
     * @var bool
     */
    protected $required;

    /**
     * Invoke helper as functor
     *
     * Proxies to {@link render()}.
     *
     * @param  null|ElementInterface $element
     * @param  null|string           $labelPosition
     * @param  bool                  $renderErrors
     * @param  string|null           $partial
     * @param  bool|false           $required
     * @return string|FormRow
     */
    public function __invoke(
        ElementInterface $element = null,
        $labelPosition = null,
        $renderErrors = null,
        $partial = null,
        $required = false
    ) {
        if (! $element) {
            return $this;
        }

        if (is_null($labelPosition)) {
            $labelPosition = $this->getLabelPosition();
        }

        if ($renderErrors !== null) {
            $this->setRenderErrors($renderErrors);
        }

        if ($partial !== null) {
            $this->setPartial($partial);
        }

        $this->setRequred($required);

        return $this->render($element, $labelPosition);
    }

    /**
     * Utility form helper that renders a label (if it exists), an element and errors
     *
     * @param  ElementInterface $element
     * @param  null|string      $labelPosition
     * @throws \Zend\Form\Exception\DomainException
     * @return string
     */
    public function render(ElementInterface $element, $labelPosition = null)
    {
        $escapeHtmlHelper    = $this->getEscapeHtmlHelper();
        $labelHelper         = $this->getLabelHelper();
        $elementHelper       = $this->getElementHelper();
        $elementErrorsHelper = $this->getElementErrorsHelper();

        $elementErrorClass = $elementErrorsHelper->render($element) ? 'has-error' : '';
        $elementRowOpen = '<div class="form-group '. $elementErrorClass .'">';
        $elementRowClose = '</div>';

        $elementContainerOpen = '<div class="col-sm-4">';
        $elementContainerClose = '</div>';

        $elementNoLabelContainerOpen = '<div class="col-md-offset-3 col-md-9">';
        $elementNoLabelContainerClose = '</div>';

        $elementErrorsContainerOpen = '<div class="help-block col-sm-reset inline col-sm-5">';
        $elementErrorsContainerClose = '</div>';

        $elementDescriptionContainerOpen = '<span class="help-block m-b-none">';
        $elementDescriptionContainerClose = '</span>';

        $elementDescription = $element->getOption('description');

        $elementLink = $element->getOption('link');

        $translator = $this->getTranslator();

        if(is_null($elementDescription))
        {
            $elementDescription = '';
        }

        if(($element instanceof Textarea))
        {
            if(strripos($element->getAttribute('class'), 'summernote'))
            {
                $elementContainerOpen = '<div class="col-sm-8">';
            }

            if($element->getAttribute('class') == 'tinymce')
            {
                $elementContainerOpen = '<div class="col-sm-8">';
            }
        }

        $label           = $element->getLabel();
        $inputErrorClass = $this->getInputErrorClass();

        if (is_null($labelPosition)) {
            $labelPosition = $this->labelPosition;
        }

        if (isset($label) && '' !== $label) {
            // Translate the label
            if (null !== ($translator)) {
                $label = $translator->translate($label, $this->getTranslatorTextDomain());
            }
        }

        // Does this element have errors ?
        if (count($element->getMessages()) > 0 && ! empty($inputErrorClass)) {
            $classAttributes = ($element->hasAttribute('class') ? $element->getAttribute('class') . ' ' : '');
            $classAttributes = $classAttributes . $inputErrorClass;

            $element->setAttribute('class', $classAttributes);
        }

        if ($this->partial) {
            $vars = [
                'element'           => $element,
                'label'             => $label,
                'labelAttributes'   => $this->labelAttributes,
                'labelPosition'     => $labelPosition,
                'renderErrors'      => $this->renderErrors,
            ];

            return $this->view->render($this->partial, $vars);
        }

        if ($this->renderErrors) {

            $messages = $element->getMessages();
            $mArray = [];
            foreach($messages as $key => $val)
            {
                $mArray[$key] = $translator->translate($val, $this->getTranslatorTextDomain());
            }

            $element->setMessages($mArray);

            $elementErrors = $elementErrorsHelper->setMessageOpenFormat('<div class="help-inline help-block">')->setMessageCloseString('</div>')->render($element);
        }

        $type = $element->getAttribute('type');

        if($type == 'radio')
        {
            $options = $element->getOptions();

            $elementContainerOpen = '<div class="col-sm-4">';

            $name = $element->getName();

            $value = $element->getValue();

            $elementString = '';
            foreach ($options['value_options'] as $k => $v)
            {
                $elementString .= '<div class="radio">
													<label>
														<input name="'.$name.'" class="'.$element->getAttribute('class').'" type="radio" value="'. $k .'" '. ($value == $k ? 'checked=checked' : '') .'>
														<span class="lbl"> '. $v .'</span>
													</label>
												</div>';
            }
            $elementContainerClose = '</div>';
        }
        elseif ($type == 'multi_checkbox')
        {
            $options = $element->getValueOptions();
            if(is_array($options) && count($options) > 0 && !is_array(current($options))){
                foreach ($options as $key => $option) {
                    $options[$key] = ['label' => $option, 'value' => $key, 'attributes' => $element->getAttributes()];
                }
            }


            $elementContainerOpen = '<div class="col-sm-4">';

            $name = $element->getName();

            $selected = $element->getValue();
            $elementString = '';
            foreach ($options as $k => $v)
            {
                if($selected && in_array($v['value'], $selected)){
                    $v['selected'] = true;
                }
                $elementString .= '<div class="checkbox">
													<label>
														<input name="'.$name.'[]" '. ((isset($v['attributes']) && isset($v['attributes']['class'])) ? 'class="'.$v['attributes']['class'].'"' : '') .' type="checkbox" value="'. $v['value'] .'" '. ((isset($v['selected']) && !empty($v['selected'])) ? 'checked=checked' : '') .' '. (isset($v['disabled']) ? 'disabled=disabled' : '') .'>
														<span class="lbl"> '. $translator->translate($v['label']) .'</span>
													</label>
												</div>';
            }
            $elementContainerClose = '</div>';
        }
        elseif ($type === 'hidden'){
            $elementRowOpen               = '';
            $elementRowClose              = '';
            $elementNoLabelContainerOpen  = '';
            $elementNoLabelContainerClose = '';
            $elementErrors                = '';
            $elementString                = $elementHelper->render($element);
        }
        else
        {
            $elementString = $elementHelper->render($element);
        }

        if ($element->hasAttribute(self::FORM_ROW_CONFIG_KEY)) {
            if (is_array($formRowConfig = $element->getAttribute(self::FORM_ROW_CONFIG_KEY))) {
                foreach ($formRowConfig as $key => $value) {
                    if (in_array($key, self::FORM_ROW_CONFIG) && isset($$key)) {
                        $$key = str_replace(['{elementErrorClass}'],[$elementErrorClass],$value);
                    }
                }
            }
        }

        // hidden elements do not need a <label> -https://github.com/zendframework/zf2/issues/5607

        if (isset($label) && '' !== $label && $type !== 'hidden') {
            $labelAttributes = [];

            if ($element instanceof LabelAwareInterface) {
                $labelAttributes = $element->getLabelAttributes();
            }

            if (! $element instanceof LabelAwareInterface || ! $element->getLabelOption('disable_html_escape')) {
                $label = $escapeHtmlHelper($label);
            }

            if($this->isRequired() || $element->getOption('required'))
            {
                $label = $label . '<span class="red"> * </span>';
            }

            if (empty($labelAttributes)) {
                $labelAttributes = $this->labelAttributes;
            }

            // Ensure element and label will be separated if element has an `id`-attribute.
            // If element has label option `always_wrap` it will be nested in any case.
            if ($element->hasAttribute('id')
                && ($element instanceof LabelAwareInterface && ! $element->getLabelOption('always_wrap'))
            ) {
                $labelOpen = '';
                $labelClose = '';
                $label = $labelHelper->openTag($element) . $label . $labelHelper->closeTag();
            } else {
                $labelOpen  = $labelHelper->openTag($labelAttributes);
                $labelClose = $labelHelper->closeTag();
            }

            // Multicheckbox elements have to be handled differently as the HTML standard does not allow nested
            // labels. The semantic way is to group them inside a fieldset
            if ($type === 'multi_checkbox'
                || $type === 'radio'
                || $element instanceof MonthSelect
                || $element instanceof Captcha
            ) {
                $markup = sprintf(
                    $elementRowOpen. $labelOpen . $label . $labelClose.$elementContainerOpen.'%s'.$elementContainerClose.$elementRowClose,
                    $elementString
                );
            } else {

                if ($label !== '' && (! $element->hasAttribute('id'))
                    || ($element instanceof LabelAwareInterface && $element->getLabelOption('always_wrap'))
                ) {
                    $label = '' . $label . '';
                }

                // Button element is a special case, because label is always rendered inside it
                if ($element instanceof Button) {
                    $labelOpen = $labelClose = $label = '';
                    $elementContainerOpen = '<div class="col-sm-8 col-sm-offset-3">';
                }

                if ($element instanceof LabelAwareInterface && $element->getLabelOption('label_position')) {
                    $labelPosition = $element->getLabelOption('label_position');
                }

                $elementIcon = '';

                if($element instanceof Date)
                {
                    $elementIcon = '<span class="input-group-addon" style=""><i class="glyphicon glyphicon-th"></i></span>';
                    $elementContainerOpen = '<div class="col-sm-4 input-group date">';
                }

                elseif($element->hasAttribute('touchSpin'))
                {
//                    $elementIcon = '<span class="input-group-btn-vertical"><button class="btn btn-default bootstrap-touchspin-up" type="button"><i class="glyphicon glyphicon-chevron-up"></i></button><button class="btn btn-default bootstrap-touchspin-down" type="button"><i class="glyphicon glyphicon-chevron-down"></i></button></span>';
                    $elementContainerOpen = '<div class="col-sm-4 input-group bootstrap-touchspin">';
                }

                switch ($labelPosition) {
                    case self::LABEL_PREPEND:
                        if ($this->renderErrors)
                        {
                            $markup = $elementRowOpen
                                        . $labelOpen . $label . $labelClose
                                        . $elementContainerOpen . $elementString . $elementIcon
                                        .$elementDescriptionContainerOpen . $elementDescription. $elementDescriptionContainerClose
                                        . $elementContainerClose

                                        . $elementErrorsContainerOpen . $elementErrors . $elementErrorsContainerClose
                                        . $elementErrorsContainerOpen . $elementLink . $elementErrorsContainerClose
                                    . $elementRowClose;
                        }
                        else
                        {
                            $markup = $elementRowOpen . $labelOpen . $label . $labelClose . $elementContainerOpen . $elementString . $elementContainerClose  . $elementRowClose;
                        }

                        break;
                    case self::LABEL_APPEND:
                    default:
                        if($this->renderErrors)
                        {
                            $markup = $elementRowOpen
                                        . $labelOpen . $label . $labelClose
                                        . $elementContainerOpen . $elementString . $elementContainerClose
                                        . $elementErrorsContainerOpen . $elementErrors . $elementErrorsContainerClose
                                    .  $elementRowClose;
                        }
                        else
                        {
                            $markup = $elementRowOpen . $labelOpen . $label . $labelClose . $elementContainerOpen . $elementString . $elementContainerClose .  $elementRowClose;
                        }
                        break;
                }
            }


        } else {
            if ($this->renderErrors) {
                $markup = $elementRowOpen . $elementNoLabelContainerOpen . $elementString . $elementNoLabelContainerClose . $elementErrors . $elementRowClose;
            } else {
                $markup = $elementRowOpen . $elementNoLabelContainerOpen . $elementString . $elementNoLabelContainerClose . $elementRowClose;
            }
        }

        return $markup;
    }

    /**
     * Set the class that is added to element that have errors
     *
     * @param  string $inputErrorClass
     * @return FormRow
     */
    public function setInputErrorClass($inputErrorClass)
    {
        $this->inputErrorClass = $inputErrorClass;
        return $this;
    }

    /**
     * Get the class that is added to element that have errors
     *
     * @return string
     */
    public function getInputErrorClass()
    {
        return $this->inputErrorClass;
    }

    /**
     * Set the attributes for the row label
     *
     * @param  array $labelAttributes
     * @return FormRow
     */
    public function setLabelAttributes($labelAttributes)
    {
        $this->labelAttributes = $labelAttributes;
        return $this;
    }

    /**
     * Get the attributes for the row label
     *
     * @return array
     */
    public function getLabelAttributes()
    {
        return $this->labelAttributes;
    }

    /**
     * Set the label position
     *
     * @param  string $labelPosition
     * @throws \Zend\Form\Exception\InvalidArgumentException
     * @return FormRow
     */
    public function setLabelPosition($labelPosition)
    {
        $labelPosition = strtolower($labelPosition);
        if (! in_array($labelPosition, [self::LABEL_APPEND, self::LABEL_PREPEND])) {
            throw new Exception\InvalidArgumentException(sprintf(
                '%s expects either %s::LABEL_APPEND or %s::LABEL_PREPEND; received "%s"',
                __METHOD__,
                __CLASS__,
                __CLASS__,
                (string) $labelPosition
            ));
        }
        $this->labelPosition = $labelPosition;

        return $this;
    }

    /**
     * Get the label position
     *
     * @return string
     */
    public function getLabelPosition()
    {
        return $this->labelPosition;
    }

    /**
     * Set if the errors are rendered by this helper
     *
     * @param  bool $renderErrors
     * @return FormRow
     */
    public function setRenderErrors($renderErrors)
    {
        $this->renderErrors = (bool) $renderErrors;
        return $this;
    }

    /**
     * Retrieve if the errors are rendered by this helper
     *
     * @return bool
     */
    public function getRenderErrors()
    {
        return $this->renderErrors;
    }

    /**
     * Set a partial view script to use for rendering the row
     *
     * @param null|string $partial
     * @return FormRow
     */
    public function setPartial($partial)
    {
        $this->partial = $partial;
        return $this;
    }

    /**
     * Retrieve current partial
     *
     * @return null|string
     */
    public function getPartial()
    {
        return $this->partial;
    }

    /**
     * Retrieve the FormLabel helper
     *
     * @return FormLabel
     */
    protected function getLabelHelper()
    {
        if ($this->labelHelper) {
            return $this->labelHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->labelHelper = $this->view->plugin('form_label');
        }

        if (! $this->labelHelper instanceof FormLabel) {
            $this->labelHelper = new FormLabel();
        }

        if ($this->hasTranslator()) {
            $this->labelHelper->setTranslator(
                $this->getTranslator(),
                $this->getTranslatorTextDomain()
            );
        }

        return $this->labelHelper;
    }

    /**
     * Retrieve the FormElement helper
     *
     * @return FormElement
     */
    protected function getElementHelper()
    {
        if ($this->elementHelper) {
            return $this->elementHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->elementHelper = $this->view->plugin('form_element');
        }

        if (! $this->elementHelper instanceof FormElement) {
            $this->elementHelper = new FormElement();
        }

        return $this->elementHelper;
    }

    /**
     * Retrieve the FormElementErrors helper
     *
     * @return FormElementErrors
     */
    protected function getElementErrorsHelper()
    {
        if ($this->elementErrorsHelper) {
            return $this->elementErrorsHelper;
        }

        if (method_exists($this->view, 'plugin')) {
            $this->elementErrorsHelper = $this->view->plugin('form_element_errors');
        }

        if (! $this->elementErrorsHelper instanceof FormElementErrors) {
            $this->elementErrorsHelper = new FormElementErrors();
        }

        return $this->elementErrorsHelper;
    }

    public function setRequred($required)
    {
        $this->required = $required;
    }

    public function isRequired()
    {
        return $this->required;
    }
}
