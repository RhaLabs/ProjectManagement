<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 * @ORM\MappedSuperclass
 */
class ProjectChangeInitiation
{
    public function IsImplemented()
    {
        if (empty($this->dateImplemented)) {
          return false;
        } else {
          return true;
        }
    }
    
    /**
     * @ORM\Column(type="boolean",nullable=true, options={"default":false})
     */
    protected $accepted;
    
    public function isAccepted()
    {
      return $this->accepted;
    }
    
    public function setAccepted($value)
    {
      $this->accepted = $value;
      
      return $this;
    }
    
    public function isDeclined()
    {
      return !$this->accepted;
    }
    
    public function setDeclined($value)
    {
      $this->accepted = !$value;
      
      return $this;
    }

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateImplemented;

    public function setDateImplemented($dateImplemented)
    {
        $this->dateImplemented = $dateImplemented;

        return $this;
    }

    public function getDateImplemented()
    {
        return $this->dateImplemented;
    }

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateAssigned;

    public function setDateAssigned($dateAssigned)
    {
        $this->dateAssigned = $dateAssigned;

        return $this;
    }

    public function getDateAssigned()
    {
        return $this->dateAssigned;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $drawingChange;

    public function setDrawingChange($drawingChange)
    {
        $this->drawingChange = $drawingChange;

        return $this;
    }

    public function getDrawingChange()
    {
        return $this->drawingChange;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    protected $drawingChangeNumber;

    public function setDrawingChangeNumber($drawingChangeNumber)
    {
        $this->drawingChangeNumber = $drawingChangeNumber;

        return $this;
    }

    public function getDrawingChangeNumber()
    {
        return $this->drawingChangeNumber;
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
