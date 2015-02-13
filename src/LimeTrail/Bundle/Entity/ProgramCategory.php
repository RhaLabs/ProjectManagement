<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProgramCategory
 * @ORM\Entity
 * @ORM\Table(name="program_category", indexes=
 {
 @ORM\Index(name="name_idx", columns={"name"})
 }
 )
 */
class ProgramCategory extends \Application\GlobalBundle\Entity\BaseProgramCategory
{
    /**
     * @ORM\OneToMany(targetEntity="ProjectInformation", mappedBy="ProgramCategory")
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
     * @return ProgramCategory
     */
    public function setProject(\LimeTrail\Bundle\Entity\ProjectInformation $project = null)
    {
        $this->project = $project;

        return $this;
    }
}
