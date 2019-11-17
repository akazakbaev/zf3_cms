<?php
namespace Application\Service;

use Application\Entity\ApplicationTranslateKey;
use Application\Entity\ApplicationTranslates;
use Doctrine\Common\Collections\Criteria;

/**
 * This service is responsible for initialzing RBAC (Role-Based Access Control).
 */
class LanguageManager
{
    /**
     * Doctrine entity manager.
     * @var \Doctrine\ORM\EntityManager
     */
    private $entityManager;

    /**
     * @var \Application\Options\LanguageOptions
     */
    private $languageOptions;

    /**
     * @var \Application\Service\DatabaseTranslationLoader
     */
    private $translateLoader;


    public function __construct($entityManager, $languageOptions, $translateLoader)
    {
        $this->entityManager = $entityManager;

        $this->languageOptions = $languageOptions;

        $this->translateLoader = $translateLoader;
    }

    public function getItemById($id)
    {
        return $this->entityManager->getRepository(ApplicationTranslateKey::class)->find($id);
    }

    public function getListQuery($params = [])
    {
        $qb = $this->entityManager->createQueryBuilder();

        $qb->from(ApplicationTranslateKey::class, 't1')
            ->select('t1')
            ->join('t1.translates', 't2')
            ->orderBy('t1.id', 'DESC')
            ;

        if(isset($params['query']))
        {
            $qb->where('(t1.key like :query OR t2.translate like :query)')
                ->setParameter('query', '%'.$params['query'].'%')
            ;
        }

        if(isset($params['js']))
        {
            $qb->andWhere('t1.js = :js')
            ->setParameter('js', $params['js'])
            ;
        }

        if(isset($params['active_language']))
        {
            $qb->andWhere('t2.locale = :locale')
                ->setParameter('locale', $this->translateLoader->getTranslator()->getLocale());
        }

        return $qb->getQuery();
    }

    public function save($data, $item = false)
    {
        $languages = $this->languageOptions->getLanguages();

        $translates = [];

        foreach ($languages as $language)
        {
            if(isset($data[$language])) $translates[$language] = $data[$language];
        }

        $conn = $this->entityManager->getConnection();
        $conn->beginTransaction();
        try{
            if($item == false)
                $item = new ApplicationTranslateKey();

            $item->setTranslateText($data['key']);
            $item->setModule('application');
            $item->setJs($data['js']);

            $this->entityManager->persist($item);

            $this->_addTranslate($translates, $item);

            // Apply changes to database.
            $this->entityManager->flush();

            $this->translateLoader->removeTranslates();

            $this->entityManager->getConnection()->commit();

            return true;

        }catch(\Exception $e)
        {
            $this->entityManager->getConnection()->rollBack();
var_dump($e->getMessage());die;
            return false;
        }
    }

    private function _addTranslate($data, $translateKey)
    {
        foreach ($data as $k => $v)
        {
            $item = null;

            if($translateKey->getId())
            {
                $qb = $this->entityManager->createQueryBuilder();

                $query = $qb->from(ApplicationTranslates::class, 't1')
                    ->select('t1')
                    ->where('t1.locale = ?1')
                    ->setParameter('1', $k)
                    ->andWhere('t1.translateKey = ?2')
                    ->setParameter('2', $translateKey)
                    ->setMaxResults(1)
                    ->getQuery()

                    ;

                $item = $query->getOneOrNullResult();
            }

            if($item == null) $item = new ApplicationTranslates();

            $item->setLocale($k);
            $item->setTranslate($v);
            $item->setTranslateKey($translateKey);

            $this->entityManager->persist($item);

        }
    }
}



