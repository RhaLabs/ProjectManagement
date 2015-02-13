<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProjectType
 * @ORM\Entity
 * @ORM\Table(name="project_type", indexes=
 {
 @ORM\Index(name="name_idx", columns={"name"})
 }
 )
 */
class ProjectType extends \Application\GlobalBundle\Entity\BaseProjectType
{
    /**
     * @ORM\OneToMany(targetEntity="ProjectInformation", mappedBy="ProjectType")
     */
    private $project;
    public function addProject($Type)
    {
        $this->project[] = $Type;
    }
    /*public function setProjects($projects) {
        foreach ($projects as $project) {
            $project->addProjectType($this);
        }
        $this->projects = $project;
    }*/

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
     * @return ProjectType
     */
    public function setProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $project = null)
    {
        $this->project = $project;

        return $this;
    }
}
