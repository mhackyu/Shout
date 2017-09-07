<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 9/7/17
 * Time: 7:03 PM
 */

namespace AppBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword()
     */
    protected $oldPassword;
}