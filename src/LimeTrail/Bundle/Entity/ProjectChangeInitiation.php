<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Application\GlobalBundle\Entity\ProjectChangeInitiation as AbstractChange;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\ProjectChangeRepository")
 * @ORM\Table(name="project_change_initiation", indexes=
        {
          @ORM\Index(name="accepted_idx", columns={"accepted"}),
          @ORM\Index(name="dateImplemented_idx", columns={"dateImplemented"}),
          @ORM\Index(name="dateAssigned_idx", columns={"dateAssigned"}),
          @ORM\Index(name="drawingChange_idx", columns={"drawingChange"})
        },
      )
 */
class ProjectChangeInitiation extends AbstractChange
{
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="ProjectInformation", inversedBy="projectChanges")
     */
    private $project;

    public function addProject(\LimeTrail\Bundle\Entity\ProjectInformation $project)
    {
        $project->addProjectChange($this);

        $this->project = $project;

        return $this;
    }

    public function getProject()
    {
        return $this->project;
    }

    /**
     * @ORM\ManyToOne(targetEntity="ChangeInitiation", inversedBy="projectChange")
     */
    private $change;

    public function addChange(\LimeTrail\Bundle\Entity\ChangeInitiation $change)
    {
        $change->setProjectChange($this);

        $this->change = $change;

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
      $this->project = new ArrayCollection();
      $this->change = new ArrayCollection();
    }
    
    public function __toString()
    {
      return get_class($this);
    }
}
