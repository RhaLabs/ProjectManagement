<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobRoles
 * @ORM\MappedSuperclass
 */
class ChangeScope
{
    /**
     * @var string
     * @ORM\Column(type="string", length=60)
     */
    protected $name;

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }
    
    public function hasDate()
    {
      if (empty($this->date)) {
        return false;
      } else {
        return true;
      }
    }   
    
    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true, options={"default":null})
     */
    protected $date;

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    } 

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
    }
    
    public function getId()
    {
        return $this->id;
    }
}
