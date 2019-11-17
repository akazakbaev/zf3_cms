<?php
/**
 * Created by PhpStorm.
 * User: RAVSHAN
 * Date: 22.02.14
 * Time: 17:48
 */

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;

class RenderWidget extends AbstractHelper
{
    private $route;

    private $application;

    private $entityManager;

    public function __construct(array $options)
    {
        foreach( $options as $key => $value )
        {
            if( property_exists($this, $key) )
            {
                $this->$key = $value;
            }
        }
    }

    public function __invoke($module, $name, $params = array())
    {
      $nameArray = explode('-', $name);

      if(count($nameArray) > 1)
      {
          $name = $nameTpl = '';
          foreach ($nameArray as $key => $value)
          {
              $name .= ucfirst($value);

              $nameTpl .= $nameTpl == '' ? strtolower($value) : '-' .strtolower($value);
          }
      }
      else
      {
          $name = ucfirst($name);
          $nameTpl = strtolower($name);
      }

      $widget_class = '\\' . ucfirst($module) . '\\Widgets\\' . $name . '\\WidgetController';
      $widget = new $widget_class(get_object_vars($this));
      return $this->getView()->render(strtolower($module) . '/widgets/' . $nameTpl, $widget->indexAction($params));
    }
} 