<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 10/17/17
 * Time: 9:51 PM
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ShoutCategoryRepository")
 * @ORM\Table(name="shout_category")
 * @UniqueEntity(fields="name", message="Shout Category already exists")
 */
class ShoutCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="30")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Shout", mappedBy="shoutCategory")
     */
    private $shout;

    public function __construct()
    {
        $this->shout = new ArrayCollection();
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
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     */
    public function setName($name)
    {
        $this->name = $name;
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
}