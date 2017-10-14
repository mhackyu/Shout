<?php
/**
 * shout - BadWordsRepository.php
 * Author: Mark Christian Paderes
 * Email: markpaderes0932@yahoo.com
 *
 * User: Paderes
 * Date: 10/13/2017
 * Time: 10:52 PM
 */

namespace AppBundle\Repository;


use Doctrine\ORM\EntityRepository;

class BadWordsRepository extends EntityRepository
{
    /**
     * This method will get all bad words from database.
     */
    public function getAllBadWords()
    {
        $results = $this->getEntityManager()
            ->createQuery('
                SELECT bw.word
                FROM AppBundle:BadWords bw
            ')
            ->getResult();
        $words = [];
        foreach ($results as $result) {
            $words [] = $result["word"];
        }
        
        return $words;
    }
}