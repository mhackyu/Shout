<?php
/**
 * shout - BadWords.php
 * Author: Mark Christian Paderes
 * Email: markpaderes0932@yahoo.com
 *
 * User: Paderes
 * Date: 10/13/2017
 * Time: 10:45 PM
 */

namespace AppBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="AppBundle\Repository\BadWordsRepository")
 * @ORM\Table(name="bad_words")
 */
class BadWords
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $word;

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
    public function getWord()
    {
        return $this->word;
    }

    /**
     * @param mixed $word
     */
    public function setWord($word)
    {
        $this->word = $word;
    }
}