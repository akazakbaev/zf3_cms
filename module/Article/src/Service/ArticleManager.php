<?php
namespace Article\Service;


use Article\Entity\ArticleArticles;
use Doctrine\ORM\EntityManager;
use Storage\Service\FileManager;
use User\Service\AuthManager;
use Zend\Mvc\Plugin\FlashMessenger\FlashMessenger;


class ArticleManager
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var FileManager
     */
    private $fileManager;

    /**
     * @var FlashMessenger
     */
    private $flashMessenger;

    /**
     * @var AuthManager
     */
    private $authManager;

    public function __construct(EntityManager $entityManager, FileManager $fileManager,
                                FlashMessenger $flashMessenger, AuthManager $authManager)
    {
        $this->entityManager = $entityManager;

        $this->fileManager = $fileManager;

        $this->flashMessenger = $flashMessenger;

        $this->authManager = $authManager;
    }

    public function save(ArticleArticles $item, $data = [])
    {
        $conn = $this->entityManager->getConnection();
        $conn->beginTransaction();
        try{
            $item->setUser($this->authManager->getViewer());

            $this->entityManager->persist($item);
            $this->entityManager->flush();

            $this->entityManager->getConnection()->commit();
        }
        catch(\Exception $e)
        {
            $this->entityManager->getConnection()->rollBack();

            $this->flashMessenger->setNamespace('error')->addMessage($e->getMessage());

            return false;
        }

        if(isset($data['photo']) && !empty($data['photo']) && !empty($data['photo']['tmp_name']))
        {
            $file = $this->fileManager->addPhoto($data['photo'], $item);

            $item->setFile($file);

            $this->entityManager->persist($item);
            $this->entityManager->flush();
        }

        return true;
    }
}



