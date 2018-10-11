<?php

namespace Application\View\Helper;


use Zend\View\Exception;
use Zend\View\Helper\AbstractHelper;

class Breadcrumbs extends AbstractHelper
{
    protected $partial;

    private $items = [];

    protected $title = '';

    protected $description = '';

    public function setTitle($title)
    {
        /**
         * @var $plugin \Zend\View\Helper\HeadTitle
         */
        $plugin = $this->getView()->plugin('headTitle');

       $plugin($title);

        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }


    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function render($container = null)
    {
        if (count($this->items)==0)
            return ''; // Do nothing if there are no items.

        $partial = $this->getPartial();

        if ($partial) {
            return $this->renderPartial($container, $partial);
        }

        return '';
    }


    public function renderPartial($container = null, $partial = null)
    {
        return $this->renderPartialModel([], $container, $partial);
    }


    public function setPartial($partial)
    {
        if (null === $partial || is_string($partial) || is_array($partial)) {
            $this->partial = $partial;
        }
        return $this;
    }


    public function getPartial()
    {
        return $this->partial;
    }


    protected function renderPartialModel(array $params, $container, $partial)
    {
        if (null === $partial) {
            $partial = $this->getPartial();
        }
        if (empty($partial)) {
            throw new Exception\RuntimeException(
                'Unable to render breadcrumbs: No partial view script provided'
            );
        }

        $model['pages'] = $this->items;
        $model['title'] = $this->getTitle();
        $model['description'] = $this->getDescription();
//var_dump($model['pages']);die;

        /** @var \Zend\View\Helper\Partial $partialHelper */
        $partialHelper = $this->view->plugin('partial');


        return $partialHelper($partial, $model);
    }

    /**
     * Sets the items.
     * @param array $items Items.
     */
    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }
}
