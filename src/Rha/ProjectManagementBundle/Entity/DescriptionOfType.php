<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * DescriptionOfType
 * @ORM\Entity
 * @ORM\Table(name="description_of_type", indexes=
 {
 @ORM\Index(name="name_idx", columns={"name"})
 }
 )
 */
class DescriptionOfType extends \Application\GlobalBundle\Entity\BaseDescriptionOfType
{
    /**
     * @ORM\OneToMany(targetEntity="ProjectInformation", mappedBy="DescriptionOfType")
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
        $this->projects->removeElement($project);
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
     * @return DescriptionOfType
     */
    public function setProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $project = null)
    {
        $this->project = $project;

        return $this;
    }
}
