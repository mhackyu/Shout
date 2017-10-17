<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 10/11/17
 * Time: 9:43 PM
 */

namespace AppBundle\Utils;


class TokenGenerator
{
    public function generateConfirmationToken()
    {
        return "mhA" . md5(uniqid()) . "ckYU";
    }

    public function generatePasswordResetToken()
    {
        return "Uy" . md5(uniqid()) . "Mh@cK";
    }
}