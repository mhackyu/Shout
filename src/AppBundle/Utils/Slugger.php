<?php
/**
 * shout - Slugger.php
 * Author: Mark Christian Paderes
 * Email: markpaderes0932@yahoo.com
 *
 * User: Paderes
 * Date: 8/21/2017
 * Time: 6:46 AM
 */

namespace AppBundle\Utils;

class Slugger {

    /**
     * @return string
     */
    public function slugify($string)
    {
        return preg_replace('/\s+/', '-', mb_strtolower(trim(strip_tags($string)), 'UTF-8')) . "-" . uniqid();
    }
}