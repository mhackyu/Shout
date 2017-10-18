<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 9/6/17
 * Time: 3:12 PM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="found_helpful")
 */
class FoundHelpful
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Advice", inversedBy="foundHelpful")
     * @ORM\JoinColumn(onDelete="cascade")
     * @Assert\Valid()
     */
    private $advice;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="foundHelpful")
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
    public function getAdvice()
    {
        return $this->advice;
    }

    /**
     * @param mixed $advice
     */
    public function setAdvice($advice)
    {
        $this->advice = $advice;
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