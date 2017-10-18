<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 10/18/17
 * Time: 10:41 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class NotificationRepository extends EntityRepository
{
    public function markAllAsSeen($user)
    {
        return $this->getEntityManager()
            ->createQuery('
                UPDATE AppBundle:Notification n 
                SET n.seen = TRUE
                WHERE n.user = :user
            ')
            ->setParameter('user', $user)
            ->getResult();
    }
}