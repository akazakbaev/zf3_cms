<?php

namespace Application\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Filter;
use Application\Classes\DefaultString;

class Truncate extends AbstractHelper
{
  public function __invoke($string, $length = 300, $chopString = null)
  {
      $filter = new Filter\StripTags();
      if (DefaultString::strlen($string) <= $length) {
          return $filter->filter($string);
      }
      if (null === $chopString) {
          $chopString = '...';
      }

      return $filter->filter(DefaultString::substr($string, 0, $length) . $chopString);
  }
}