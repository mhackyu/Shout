<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 10/18/17
 * Time: 12:20 AM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class ShoutCategoryRepository extends EntityRepository
{
    public function findAllASC()
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT c
                FROM AppBundle:ShoutCategory c 
                ORDER BY c.name ASC
            ')
            ->getResult();
    }
}