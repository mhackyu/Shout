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
        $q = $this->getEntityManager()
            ->createQuery('
                SELECT q 
                FROM AppBundle:Quote q 
                WHERE q.isQuoteOfTheDay = TRUE
            ')
            ->getResult();
        return $q[0];
    }
}