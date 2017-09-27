<?php
/**
 * Created by PhpStorm.
 * User: mhackyu
 * Date: 9/9/17
 * Time: 10:42 AM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\QuoteRepository")
 * @ORM\Table(name="quote")
 */
class Quote
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $content;

    /**
     * @ORM\Column(type="string")
     */
    private $quoteBy;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isQuoteOfTheDay;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isPublished;

    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Entity\QuoteCategory", inversedBy="quote")
     */
    private $category;

    public function __construct()
    {
        $this->isPublished = false;
        $this->isQuoteOfTheDay = false;
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
    public function getQuoteBy()
    {
        return $this->quoteBy;
    }

    /**
     * @param mixed $quoteBy
     */
    public function setQuoteBy($quoteBy)
    {
        $this->quoteBy = $quoteBy;
    }

    /**
     * @return mixed
     */
    public function isQuoteOfTheDay()
    {
        return $this->isQuoteOfTheDay;
    }

    /**
     * @param mixed $isQuoteOfTheDay
     */
    public function setIsQuoteOfTheDay($isQuoteOfTheDay)
    {
        $this->isQuoteOfTheDay = $isQuoteOfTheDay;
    }

    /**
     * @return mixed
     */
    public function isPublished()
    {
        return $this->isPublished;
    }

    /**
     * @param mixed $isPublish
     */
    public function setIsPublished($isPublished)
    {
        $this->isPublished = $isPublished;
    }

    /**
     * @return mixed
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param mixed $category
     */
    public function setCategory($category)
    {
        $this->category = $category;
    }

}