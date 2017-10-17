<?php
/**
 * shout - Love.php
 * Author: Mark Christian Paderes
 * Email: markpaderes0932@yahoo.com
 *
 * User: Paderes
 * Date: 8/21/2017
 * Time: 5:04 PM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="love")
 */
class Love
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Shout", inversedBy="love")
     * @ORM\JoinColumn(onDelete="cascade")
     */
    private $shout;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="love")
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