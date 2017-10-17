<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Shout
 *
 * @ORM\Table(name="shout")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShoutRepository")
 */
class Shout
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="100")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     * @Assert\NotBlank()
     * @Assert\Length(min="10")
     */
    private $body;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $updatedAt;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="shout")
     * @Assert\Valid()
     */
    private $user;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Advice", mappedBy="shout")
     * @ORM\OrderBy(value={"createdAt" = "DESC"})
     */
    private $advice;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Love", mappedBy="shout")
     */
    private $love;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Loud", mappedBy="shout")
     */
    private $loud;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\ShoutCategory", inversedBy="shout")
     * @Assert\Valid()
     */
    private $shoutCategory;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->love = new ArrayCollection();
        $this->loud = new ArrayCollection();
        $this->advice = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Shout
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set body
     *
     * @param string $body
     *
     * @return Shout
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * @return mixed
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * @param mixed $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
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
    public function getLove()
    {
        return $this->love;
    }

    /**
     * @param mixed $love
     */
    public function setLove($love)
    {
        $this->love = $love;
    }

    /**
     * @return mixed
     */
    public function getLoud()
    {
        return $this->loud;
    }

    /**
     * @param mixed $loud
     */
    public function setLoud($loud)
    {
        $this->loud = $loud;
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
    public function getShoutCategory()
    {
        return $this->shoutCategory;
    }

    /**
     * @param mixed $shoutCategory
     */
    public function setShoutCategory($shoutCategory)
    {
        $this->shoutCategory = $shoutCategory;
    }

}

