<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Page\Controller;

use Application\Classes\ActionController;
use Application\Service\ItemManager;
use Doctrine\ORM\EntityManager;
use Page\Entity\PagePages;

class IndexController extends ActionController
{
    /**
     * Entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var ItemManager
     */
    private $itemManager;

    public function __construct(EntityManager $entityManager, ItemManager $itemManager)
    {
        $this->entityManager = $entityManager;

        $this->itemManager = $itemManager;
    }

    public function viewAction()
    {
        $name = $this->params()->fromRoute('name', false);

        $item = $this->entityManager->getRepository(PagePages::class)->findOneBy(['name' => $name]);

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
