<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 9/6/17
 * Time: 1:39 PM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\LoudRepository")
 * @ORM\Table(name="loud")
 */
class Loud
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Shout", inversedBy="loud")
     * @ORM\JoinColumn(onDelete="cascade")
     * @Assert\Valid()
     */
    private $shout;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="loud")
     * @Assert\Valid()
     */
    private $user;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getShout()
    {
        return $this->shout;
    }

    /**
     * @param mixed $shout
     */
    public function setShout($shout)
    {
        $this->shout = $shout;
    }

    /**
     * @return mixed
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @param mixed $user
     */
    public function setUser($user)
    {
        $this->user = $user;
    }
}