<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 9/9/17
 * Time: 11:41 AM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class QuoteRepository extends EntityRepository
{
    /**
     * This method will reset quote of the day field to false
     * @return array
     */
    public function resetQuoteOfTheDay()
    {
        return $this->getEntityManager()
            ->createQuery('
                UPDATE AppBundle:Quote q
                SET q.isQuoteOfTheDay = FALSE 
                WHERE q.isQuoteOfTheDay = TRUE
            ')
            ->getResult();
    }

    public function quoteOfTheDay()
    {
        return $this->getEntityManager()
            ->createQuery('
                SELECT q 
                FROM AppBundle:Quote q 
                WHERE q.isQuoteOfTheDay = TRUE
            ')
//<<<<<<< HEAD
            ->getOneOrNullResult();
//        $q = $this->getEntityManager()
//            ->createQuery('
//                SELECT q
//                FROM AppBundle:Quote q
//                WHERE q.isQuoteOfTheDay = TRUE
//            ')
//            ->getOneOrNullResult();
//
//        if (empty($q)) {
//            return null;
//        }
//        return $q[0];

//=======
//            ->getResult();
//
//        if (empty($q)) {
//            return null;
//        }
//        return $q[0];
//>>>>>>> df6bcee302e4dc7b5ebc4a42d0ef91452746fad8
    }
}