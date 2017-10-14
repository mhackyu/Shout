<?php
/**
 * shout - UserRepository.php
 * Author: Mark Christian Paderes
 * Email: markpaderes0932@yahoo.com
 *
 * User: Paderes
 * Date: 8/19/2017
 * Time: 4:40 PM
 */

namespace AppBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Security\User\UserLoaderInterface;

class UserRepository extends EntityRepository implements UserLoaderInterface
{
    public function loadUserByUsername($username)
    {
        return $this->createQueryBuilder('u')
            ->where('u.username = :username OR u.email = :email')
            ->setParameter('username', $username)
            ->setParameter('email', $username)
            ->getQuery()
            ->getOneOrNullResult();
    }
    public function searchUser($username)
    {
        //TODO: dapat yung mga nasesearch ay mga active/enabled users lang.
        return $this->getEntityManager()
            ->createQuery('
                SELECT u
                FROM AppBundle:User u 
                WHERE u.username LIKE :uname
            ')
            ->setParameter('uname', "%" . $username . "%")
            ->getResult();
    }

     public function findUserByUsername($str)
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT u
                FROM AppBundle:User u
                WHERE u.username LIKE :str
            ')
            ->setParameter("str","%".$str."%")
            ->getResult();
    }
}