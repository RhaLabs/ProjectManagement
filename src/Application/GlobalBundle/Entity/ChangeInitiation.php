<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 * @ORM\MappedSuperclass
 */
class ChangeInitiation
{
    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $title;

    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @var string
     * @ORM\Column(type="integer", unique=true)
     */
    protected $number;

    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    public function getNumber()
    {
        return $this->number;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $comment;

    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    public function getComment()
    {
        return $this->comment;
    }
    
    /**
     * @var string
     * @ORM\Column(type="datetime")
     */
    protected $releaseDate;

    public function setReleaseDate($date)
    {
        $this->releaseDate = $date;

        return $this;
    }

    public function getReleaseDate()
    {
        return $this->releaseDate;
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
