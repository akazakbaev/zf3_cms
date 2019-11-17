<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Article\Controller;

use Application\Classes\ActionController;
use Application\Classes\AdminController;
use Article\Service\ArticleManager;
use Article\Entity\ArticleArticles;
use Application\Options\LanguageOptions;
use Article\Form\Create;
use Doctrine\ORM\EntityManager;

class IndexController extends ActionController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var ArticleManager
     */
    private $articleManager;

    public function __construct(EntityManager $entityManager, ArticleManager $articleManager)
    {
        $this->entityManager = $entityManager;

        $this->articleManager = $articleManager;
    }

    public function indexAction()
    {
        $page = $this->params()->fromQuery('page', 1);

        $paginator = $this->entityManager->getRepository(ArticleArticles::class)->getItems(['page' => $page]);

        return [
            'items' => $paginator
        ];
    }

    public function viewAction()
    {
        $id = $this->params()->fromRoute('id', false);

        $item = $this->entityManager->getRepository(ArticleArticles::class)->find($id);

        if ($item == null)
        {
            $this->getResponse()->setStatusCode(404);
            return;
        }

        return [
            'item' => $item
        ];
    }
}
