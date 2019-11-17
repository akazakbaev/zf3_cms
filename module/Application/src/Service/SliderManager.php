<?php
namespace Application\Service;


use Application\Entity\ApplicationSliders;
use Doctrine\ORM\EntityManager;
use Storage\Service\FileManager;


class SliderManager
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

    private $flashMessenger;

    public function __construct(EntityManager $entityManager, FileManager $fileManager, $flashMessenger)
    {
        $this->entityManager = $entityManager;

        $this->fileManager = $fileManager;

        $this->flashMessenger = $flashMessenger;
    }

    public function save(ApplicationSliders $item, $data = [])
    {
        $conn = $this->entityManager->getConnection();
        $conn->beginTransaction();
        try{
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
            $this->fileManager->setMainImageSize(2000, 2000);
            $this->fileManager->setThumbImageSize(300, 300);

            $file = $this->fileManager->addPhoto($data['photo'], $item);

            $item->setFile($file);

            $this->entityManager->persist($item);
            $this->entityManager->flush();
        }

        return true;
    }
}



