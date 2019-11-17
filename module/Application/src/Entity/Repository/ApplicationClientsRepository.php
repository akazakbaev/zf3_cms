<?php
/**
 * Created by PhpStorm.
 * User: akazakbaev@srs.lan
 * Date: 2/26/18
 * Time: 7:30 PM
 */
namespace Application\Entity\Repository;


use Application\Classes\AbstractTableRepository;


class ApplicationClientsRepository extends AbstractTableRepository
{
    public function getItems($params = [], $queryType = self::TYPE_PAGINATOR)
    {
        $qb = $this->createQueryBuilder('s');

        if(isset($params['status']) && !empty($params['status']))
        {
            $qb->andWhere('s.status = :status')
                ->setParameter('status', $params['status']);
        }

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
}