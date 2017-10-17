<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 9/6/17
 * Time: 12:42 PM
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\AdviceRepository")
 * @ORM\Table(name="advice")
 */
class Advice
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min="1")
     */
    private $content;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Shout", inversedBy="advice")
     * @ORM\JoinColumn(onDelete="cascade")
     * @Assert\Valid()
     */
    private $shout;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="advice")
     * @Assert\Valid()
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\FoundHelpful", mappedBy="advice")
     */
    private $foundHelpful;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->foundHelpful = new ArrayCollection();
    }

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
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content)
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @param mixed $createdAt
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;
    }

    /**
     * @return mixed
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @param mixed $updatedAt
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;
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

    /**
     * @return mixed
     */
    public function getFoundHelpful()
    {
        return $this->foundHelpful;
    }

    /**
     * @param mixed $foundHelpful
     */
    public function setFoundHelpful($foundHelpful)
    {
        $this->foundHelpful = $foundHelpful;
    }
}