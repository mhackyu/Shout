<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 9/9/17
 * Time: 10:34 AM
 */

namespace AppBundle\Entity;


use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="quote_category")
 * @UniqueEntity(fields="name", message="Quote Category already exists")
 */
class QuoteCategory
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank()
     * @Assert\Length(min="3", max="100")
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity="AppBundle\Entity\Quote", mappedBy="category")
     * @Assert\Valid()
     */
    private $quote;

    public function __construct()
    {
        $this->quote = new ArrayCollection();
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
    public function getQuote()
    {
        return $this->quote;
    }

    /**
     * @param mixed $quote
     */
    public function setQuote($quote)
    {
        $this->quote = $quote;
    }

}