<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProgramYear
 * @ORM\Entity
 * @ORM\Table(name="program_year", indexes=
        {
          @ORM\Index(name="py_idx", columns={"year"})
        }
      )
 */
class ProgramYear extends \Application\GlobalBundle\Entity\BaseProgramYear
{
    /**
     * @ORM\OneToMany(targetEntity="ProjectInformation", mappedBy="ProgramYear")
     */
    private $project;
    public function addProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $Type)
    {
        $this->project[] = $Type;
    }
    public function __construct()
    {
        $this->project = new ArrayCollection();
    }

    /**
     * Remove projects
     *
     * @param \Rha\ProjectManagementBundle\Entity\ProjectInformation $projects
     */
    public function removeProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $project)
    {
        $this->project->removeElement($project);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set project
     *
     * @param  \Rha\ProjectManagementBundle\Entity\ProjectInformation $project
     * @return ProgramYear
     */
    public function setProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $project = null)
    {
        $this->project = $project;

        return $this;
    }
}
