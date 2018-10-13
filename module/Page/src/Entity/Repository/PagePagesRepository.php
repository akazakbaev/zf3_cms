<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/26/18
 * Time: 7:30 PM
 */
namespace Page\Entity\Repository;

use Doctrine\ORM\EntityRepository;
use Ishrm\Entity\StDeppost;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as DoctrineAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Ishrm\Entity\StEmplhistory;
use Zend\Paginator\Paginator;

class PagePagesRepository extends EntityRepository
{
    const TYPE_PAGINATOR = 'paginator';
    const TYPE_QUERY = 'query';
    const TYPE_RECORD = 'record';

    public function getItems($params = [], $queryType = self::TYPE_PAGINATOR)
    {
        $qb = $this->createQueryBuilder('s');

        switch ($queryType) {
            case self::TYPE_PAGINATOR:
                return $this->buildPaginator($qb->getQuery(), $params);
                break;
            case self::TYPE_QUERY:
                return $qb->getQuery();
                break;
            case self::TYPE_RECORD:
                return $qb->getQuery()->getResult();
                break;
        }
    }

    /**
     * @param \Doctrine\ORM\Query $query
     * @param $params
     * @return \Zend\Paginator\Paginator
     */
    private function buildPaginator($query, $params)
    {
        $adapter = new DoctrineAdapter(new ORMPaginator($query, false));
        $paginator = new Paginator($adapter);
        $paginator->setDefaultItemCountPerPage($params['count'] ?? 20);
        $paginator->setCurrentPageNumber($params['page'] ?? 1);

        return $paginator;
    }
}