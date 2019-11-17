<?php
/**
 * Created by PhpStorm.
 * User: RAVSHAN
 * Date: 22.02.14
 * Time: 18:01
 */

namespace Article\Widgets\NewestArticles;

use Application\Classes\AbstractWidgetController;

use Article\Entity\ArticleArticles;

class WidgetController extends AbstractWidgetController
{
  public function indexAction($params)
  {
        $items = $this->entityManager->getRepository(ArticleArticles::class)
            ->getItems(['count' => 3]);

        $params['items'] = $items;
     return $params;
  }
} 