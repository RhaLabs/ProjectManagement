<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="omniclass_elements"
      )
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\OmniclassElementRepository")
 */
class OmniclassElement
{
    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    private $number;

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
    private $titleLevelOne;

    public function setTitleLevelOne($title)
    {
        $this->titleLevelOne = $title;

        return $this;
    }

    public function getTitleLevelOne()
    {
        return $this->titleLevelOne;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    private $titleLevelTwo;

    public function setTitleLevelTwo($title)
    {
        $this->titleLevelTwo = $title;

        return $this;
    }

    public function getTitleLevelTwo()
    {
        return $this->titleLevelTwo;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    private $titleLevelThree;

    public function setTitleLevelThree($title)
    {
        $this->titleLevelThree = $title;

        return $this;
    }

    public function getTitleLevelThree()
    {
        return $this->titleLevelThree;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    private $titleLevelFour;

    public function setTitleLevelFour($title)
    {
        $this->titleLevelFour = $title;

        return $this;
    }

    public function getTitleLevelFour()
    {
        return $this->titleLevelFour;
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
