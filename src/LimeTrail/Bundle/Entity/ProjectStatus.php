<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProjectStatus
 * @ORM\Entity
 * @ORM\Table(name="project_status", indexes=
      {
        @ORM\Index(name="name_idx", columns={"name"})
      }
    )
 */
class ProjectStatus extends \Application\GlobalBundle\Entity\BaseProjectStatus
{
    /**
     * @ORM\OneToMany(targetEntity="ProjectInformation", mappedBy="ProjectStatus")
     */
    private $project;
    public function addProject(\LimeTrail\Bundle\Entity\ProjectInformation $Type)
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
     * @param \LimeTrail\Bundle\Entity\ProjectInformation $projects
     */
    public function removeProject(\LimeTrail\Bundle\Entity\ProjectInformation $project)
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
     * @param  \LimeTrail\Bundle\Entity\ProjectInformation $project
     * @return ProjectStatus
     */
    public function setProject(\LimeTrail\Bundle\Entity\ProjectInformation $project = null)
    {
        $this->project = $project;

        return $this;
    }
}
