<?php

namespace AppBundle\Repository;

/**
 * ShoutRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ShoutRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get all shouts except of the current user
     * @param $user
     * @return array
     */
    public function shoutsDQL()
    {
        return $this->getEntityManager()
            ->createQuery('
              SELECT u FROM AppBundle:Shout u
              ORDER BY u.createdAt DESC  
            ');
    }

    /**
     * Get all shouts except of the current user
     * @param $user
     * @return array
     */
    public function shoutsByCategoryDQL($type)
    {
        return $this->getEntityManager()
            ->createQuery('
              SELECT u FROM AppBundle:Shout u
              WHERE u.shoutCategory = :type
              ORDER BY u.createdAt DESC  
            ')
            ->setParameter("type", $type);
    }

    /**
     * Get all shouts except of the current user
     * @param $user
     * @return array
     */
    public function shouts()
    {
        return $this->getEntityManager()
            ->createQuery('
              SELECT u FROM AppBundle:Shout u
              ORDER BY u.createdAt DESC  
            ')
            ->getResult();
    }

    /**
     * Get shouts within specific range of date
     * @param $start - start date
     * @param $end - end date
     * @return array
     */
    public function shoutsWithin($start, $end)
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT s FROM AppBundle:Shout s 
                WHERE s.createdAt < :end AND s.createdAt > :start 
            ')
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getResult();
    }

    /**
     * Get top shouts within specific range of date
     * @param $start - start date
     * @param $end - end date
     * @param $max - max result
     * @return array
     */
    public function topShoutsWithin($start, $end, $max = 10)
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT s.title, s.slug, COUNT(l.id) as cnt
                FROM AppBundle:Loud l
                INNER JOIN AppBundle:Shout s
                WHERE s.id = l.shout AND s.createdAt < :end AND s.createdAt > :start
                GROUP BY l.shout 
                ORDER BY cnt DESC
            ')
            ->setMaxResults($max)
            ->setParameter('start', $start)
            ->setParameter('end', $end)
            ->getResult();
    }

    public function findShoutByTitle($str)
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT s
                FROM AppBundle:Shout s
                WHERE s.title LIKE :str
            ')
            ->setParameter("str","%".$str."%")
            ->getResult();
    }
}
