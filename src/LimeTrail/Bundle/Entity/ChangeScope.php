<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Application\GlobalBundle\Entity\ChangeScope as AbstractChange;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\ChangeScopeRepository")
 * @ORM\Table(name="change_scope", indexes=
 {
 @ORM\Index(name="name_idx", columns={"name"}),
 @ORM\Index(name="date_idx", columns={"date"}),
 @ORM\Index(name="date_name_idx", columns={"name","date"})
 }
 )
 */
class ChangeScope extends AbstractChange
{
    /**
     * @ORM\ManyToMany(targetEntity="ChangeInitiation", mappedBy="scopes")
     */
    private $change;

    public function addChange($change)
    {
        $this->change->add($change);

        return $this;
    }

    public function getChange()
    {
        return $this->change;
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

    public function __construct()
    {
        $this->change = new ArrayCollection();
    }

    public function __toString()
    {
        return get_class($this);
    }
}
