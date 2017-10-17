<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 9/6/17
 * Time: 1:10 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class AdviceRepository extends EntityRepository
{
    /**
     * Get top advices within specific range of date
     * @param $start - start date
     * @param $end - end date
     * @param $max - max result
     * @return array
     */
    public function topAdvicesWithin($start, $end, $max = 10)
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT a.id, a.content, COUNT(h) as cnt
                FROM AppBundle:FoundHelpful h
                INNER JOIN AppBundle:Advice a
                WHERE a.id = h.advice AND a.createdAt < :end AND a.createdAt > :start
                GROUP BY h.advice
                ORDER BY cnt DESC
            ')
            ->setMaxResults($max)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getResult();
    }
}