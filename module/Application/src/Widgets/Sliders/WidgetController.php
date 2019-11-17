<?php
/**
 * Created by PhpStorm.
 * User: RAVSHAN
 * Date: 22.02.14
 * Time: 18:01
 */

namespace Application\Widgets\Sliders;

use Application\Classes\AbstractWidgetController;
use Application\Entity\ApplicationSliders;

class WidgetController extends AbstractWidgetController
{
  public function indexAction($params)
  {
        $items = $this->entityManager->getRepository(ApplicationSliders::class)->getItems(['status' => 1]);
            ;

        $params['items'] = $items;
     return $params;
  }
} 