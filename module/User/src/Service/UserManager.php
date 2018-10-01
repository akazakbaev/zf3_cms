<?php
namespace User\Service;

use User\Entity\UserLevels;
use User\Entity\UserUsers;
use Zend\Crypt\Password\Bcrypt;

/**
 * This service is responsible for adding/editing users
 * and changing user password.
 */
class UserManager
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;


    /**
     * Constructs the service.
     */
    public function __construct($entityManager)
    {
        $this->entityManager = $entityManager;
    }

    public function getEntityManager()
    {
        return $this->entityManager;
    }

    public function getUserById($user_id)
    {
        return $this->entityManager->getRepository(UserUsers::class)->find($user_id);
    }

    public function getListQuery($params = [])
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->from(UserUsers::class, 't1')
            ->select('t1')
        ;

        if(isset($params['query']))
        {

        }

        return $qb->getQuery();
    }

    public function save($data = array(), $item = null)
    {
        $conn = $this->entityManager->getConnection();
        $conn->beginTransaction();
        try{
            if($item == null)
                $item = new UserUsers();

            $level = $this->entityManager->getRepository(UserLevels::class)->find($data['level_id']);

            if(isset($data['pin']))
                $item->setPin($data['pin']);

            if(isset($data['fname']))
                $item->setFname($data['fname']);

            if(isset($data['lname']))
                $item->setLname($data['lname']);

            if(isset($data['pname']))
                $item->setPname($data['pname']);

            if(isset($data['status']))
                $item->setStatus($data['status']);

            if(isset($data['email']))
                $item->setEmail($data['email']);

            if(isset($data['bdate']))
                $item->setBdate(new \DateTime($data['bdate']));

            if(isset($data['username']))
                $item->setUsername($data['username']);

            $item->setLevel($level);
            $item->setCreationDate(new \DateTime());
            $item->setLocale('ru_RU');

            if(isset($data['password']))
            {
                $bcrypt = new Bcrypt();

                $passwordHash = $bcrypt->create($data['password']);
                $item->setPassword($passwordHash);
            }

            if(isset($data['state_id']))
            {
                $item->setStateId($data['state_id']);
            }

            if(isset($data['main_state_id']))
            {
                $item->setMainStateId($data['main_state_id']);
            }

            if(isset($data['photo']))
            {
                $photo = $data['photo'];
                if (is_array($photo) && !empty($photo['tmp_name'])) {
                    $item->setPhoto(null);
                    $fileItem = $this->fileManager->addPhoto($photo, $item);
                    $item->setPhoto($fileItem);
                }
            }

            $this->entityManager->persist($item);

            // Apply changes to database.
            $this->entityManager->flush();

            $this->entityManager->getConnection()->commit();

            return $item;

        }catch(\Exception $e){

            $this->entityManager->getConnection()->rollBack();

            var_dump($e->getMessage());die;
        }
    }
}

