<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Prototype
 * @ORM\Entity
 * @ORM\Table(name="prototype", indexes=
 {
 @ORM\Index(name="name_idx", columns={"name"})
 }
 )
 */
class Prototype extends \Application\GlobalBundle\Entity\BasePrototype
{
    /**
     * @ORM\OneToMany(targetEntity="ProjectInformation", mappedBy="Prototype")
     */
    private $project;
    public function addProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $Type)
    {
        $this->project[] = $Type;
    }

    /**
     * @ORM\OneToMany(targetEntity="FuelStationInformation", mappedBy="Prototype")
     */
    private $fuelStation;
    public function addFuelStation(\Rha\ProjectManagementBundle\Entity\ProjectInformation $Type)
    {
        $this->fuelStation[] = $Type;
    }

    public function __construct()
    {
        $this->project = new ArrayCollection();

        $this->fuelStation[] = new ArrayCollection();
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
     * @return Prototype
     */
    public function setProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $project = null)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Remove fuel stations
     *
     * @param \Rha\ProjectManagementBundle\Entity\ProjectInformation $projects
     */
    public function removeFuelStation(\Rha\ProjectManagementBundle\Entity\ProjectInformation $project)
    {
        $this->fuelStation->removeElement($project);
    }

    /**
     * Get fuel stations
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getFuelStation()
    {
        return $this->fuelStation;
    }

    /**
     * Set fuel station
     *
     * @param  \Rha\ProjectManagementBundle\Entity\ProjectInformation $project
     * @return Prototype
     */
    public function setFuelStation(\Rha\ProjectManagementBundle\Entity\ProjectInformation $project = null)
    {
        $this->fuelStation = $project;

        return $this;
    }
}
