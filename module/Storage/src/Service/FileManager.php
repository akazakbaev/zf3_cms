<?php
namespace Storage\Service;

use Application\Entity\ApplicationFiles;
use Application\Exception\ImageException;
use Application\Image\Image;
use Application\Classes\AbstractEntityItem;
use Storage\Entity\StorageFiles;
use Storage\Entity\StorageServices;


class FileManager
{
    const   FILE_TYPE_NORMAL = 'thumb.normal';
    const   FILE_TYPE_ICON = 'thumb.icon';

    protected $_mainImageSizes = array('x' => 700, 'y' => 700);

    protected $_thumbImageSizes = array('x' => 160, 'y' => 160);

    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \User\Service\AuthManager
     */
    private $authManager;

    /**
     * @var StorageServices
     */
    private $storageService;


    private $store;

    /**
     * FileManager constructor.
     * @param $entityManager
     * @param $authManager
     * @param $storageService
     */

    public function __construct($entityManager, $authManager, $storageService)
    {
        $this->entityManager = $entityManager;

        $this->authManager = $authManager;

        $this->storageService = $storageService;

        $this->store = $this->storageService->getStoreService();
    }

    public function getPhotoUrl($id, $type = null)
    {
        /** @var StorageFiles $file */
        $file = $this->getFile($id, $type);

        if($file == null)
            return false;

        return $file->map();
    }


    public function getFile($id, $type)
    {
        if($type)
        {
            return $this->entityManager->getRepository(StorageFiles::class)
                ->findOneBy(['parentFileId' => $id, 'type' => $type]);
        }

        return $this->entityManager->getRepository(StorageFiles::class)
            ->find($id);
    }

    /**
     * @param $photo
     * @param $entityItem
     * @return StorageFiles
     * @throws ImageException
     * @throws \Application\Image\Exception
     * @throws \Application\Image\Exception
     */

    public function addPhoto($photo, AbstractEntityItem $entityItem)
    {
        if (is_array($photo) && !empty($photo['tmp_name']))
        {
            $file = $photo['tmp_name'];
            $fileName = $photo['name'];
        } else if (is_string($photo) && file_exists($photo)) {
            $file = $photo;
            $fileName = $photo;
        } else {
            throw new ImageException('invalid argument passed to setPhoto');
        }

        if (!$fileName) {
            $fileName = $file;
        }

        $extension = ltrim(strrchr(basename($fileName), '.'), '.');
        $base = rtrim(substr(basename($fileName), 0, strrpos(basename($fileName), '.')), '.');
        $path = APPLICATION_PATH . '/temporary';
        $params = array(
            'parent_type' => $entityItem->getItemType(),
            'parent_id' => $entityItem->getIdentity(),
            'user' => $this->authManager->getViewer(),
            'name' => basename($fileName),
        );

        // Resize image (main)
        $mainPath = $path . '/' . $base . '_m.' . $extension;
        $image = Image::factory();
        $image->open($file)
            ->resize($this->_mainImageSizes['x'], $this->_mainImageSizes['y'])
            ->write($mainPath)
            ->destroy();

        // Resize image (normal)
        $normalPath = $path . '/' . $base . '_in.' . $extension;
        $image = Image::factory();
        $image->open($file)
            ->resize($this->_thumbImageSizes['x'], $this->_thumbImageSizes['y'])
            ->write($normalPath)
            ->destroy();

        // Resize image (icon)
        $image = Image::factory();
        $image->open($file);

        $iSquarePath = $path . '/' . $base . '_is.' . $extension;
        $size = min($image->height, $image->width);
        $x = ($image->width - $size) / 2;
        $y = ($image->height - $size) / 2;

        $image->resample($x, $y, $size, $size, 100, 100)
            ->write($iSquarePath)
            ->destroy();

        // Store
        $iMain = $this->createFile($mainPath, $params);
        $iIconNormal = $this->createFile($normalPath, $params);
        $iSquare = $this->createFile($iSquarePath, $params);

        $this->bridge($iMain, $iIconNormal, 'thumb.normal');
        $this->bridge($iMain, $iSquare, 'thumb.icon');

        // Remove temp files
        @unlink($mainPath);
        @unlink($normalPath);
        @unlink($iSquarePath);


        return $iMain;
    }

    /**
     * @param $photo
     * @param AbstractEntityItem $entityItem
     * @return ApplicationFiles
     * @throws ImageException
     */
    public function addFile($photo, AbstractEntityItem $entityItem)
    {
        if (is_array($photo) && !empty($photo['tmp_name']))
        {
            $file = $photo['tmp_name'];
            $fileName = $photo['name'];
        } else if (is_string($photo) && file_exists($photo)) {
            $file = $photo;
            $fileName = $photo;
        } elseif(is_object($photo) && $photo instanceof StorageFiles)
        {
            if($photo->getId())
            {
                return $photo;
            }
            else
            {
                $file = $photo->getTmpName();
                $fileName = $photo->getName();
            }
        }
        else {
            throw new ImageException('invalid argument passed to setFile');
        }

        if (!$fileName) $fileName = $file;

        $extension = ltrim(strrchr(basename($fileName), '.'), '.');

        $params = array(
            'parent_type' => $entityItem->getItemType(),
            'parent_id' => $entityItem->getIdentity(),
            'user' => $this->authManager->getViewer(),
            'name' => basename($fileName),
            'extension' => $extension
        );

        $iMain = $this->createFile($file, $params);


        return $iMain;
    }

    public function createFile($file, $params)
    {
        $item = new StorageFiles();

        $item->setParentType($params['parent_type']);
        $item->setParentId($params['parent_id']);
        $item->setName($params['name']);
        $item->setOwnerId($params['user']->getIdentity());
        $item->setOwnerType($params['user']->getItemType());

        $meta = $this->getStore()->fileInfo($file);

        if($meta['extension'] == '' && isset($params['extension']))
        {
            $meta['extension'] = $params['extension'];
        }

        $item->setMimeMajor($meta['mime_major']);
        $item->setMimeMinor($meta['mime_minor']);
        $item->setHash($meta['hash']);
        $item->setExtension($meta['extension']);
        $item->setSize($meta['size']);
        $item->setService($this->storageService);

        $path = $this->getStore()->store($item, $meta['tmp_name']);

        $item->setStoragePath($path);

        $this->entityManager->persist($item);

        $this->entityManager->flush();

        return $item;
    }

    public function getStore()
    {
        return $this->store;
    }

    public function bridge(StorageFiles $parent, StorageFiles $child, $type)
    {
        $child->setParentFileId($parent->getId());
        $child->setType($type);

        $this->entityManager->persist($child);

        $this->entityManager->flush();

        return $this;
    }
}



