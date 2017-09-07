<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 9/7/17
 * Time: 2:08 PM
 */

namespace AppBundle\Service;


use Doctrine\ORM\EntityManager;

/**
 * Class TopShouts
 * This class will manage the daily, weekly and monthly top shouts posted by all users.
 * @author Mark Christian E. Paderes <markpaderes0932@yahoo.com>
 * @package AppBundle\Service
 */
class TopShouts
{
    private $em;
    private $date;
    public static $DAY = "day";
    public static $WEEK = "week";
    public static $MONTH = "month";

    public function __construct(EntityManager $em)
    {
        $this->em = $em;
        $this->date = new \DateTime("now");
    }

    /**
     * Get top shouts per day, per week or per month.
     * @param string $type
     * @return array
     */
    public function getTopShouts($type = "week")
    {
        if ($type == self::$DAY) {
            return $this->em->getRepository('AppBundle:Shout')
                ->topShoutsWithin($this->generateDate("now-1day"), $this->date);
        }
        elseif ($type == self::$WEEK) {
            return $this->em->getRepository('AppBundle:Shout')
                ->topShoutsWithin($this->generateDate("now-1week"), $this->date);
        }
        elseif ($type == self::$MONTH) {
            return $this->em->getRepository('AppBundle:Shout')
                ->topShoutsWithin($this->generateDate("now-1month"), $this->date);
        }
    }

    /**
     * Generate date
     * @param $str
     * @return \DateTime
     */
    private function generateDate($str)
    {
        return new \DateTime($str);
    }
}