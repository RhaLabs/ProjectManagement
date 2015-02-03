<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * StoreInformation
 * @ORM\Entity
 * @ORM\Table(name="fuel_station_information", indexes={@ORM\Index(name="idx", columns={"dispenserQuantity"})})
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\StoreInformationRepository")
 */
class FuelStationInformation
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    private $dispenserQuantity;

    public function getDispenserQuantity()
    {
        return $this->dispenserQuantity;
    }

    public function setDispenserQuantity($quantity = 0)
    {
        $this->dispenserQuantity = $quantity;

        return $this;
    }

    /**
     * @var integer
     * @ORM\Column(type="string")
     */
    private $serviceBuildingLocation;

    public function getServiceBuuildingLocation()
    {
        return $this->serviceBuildingLocation;
    }

    public function setServiceBuildingLocation($location = null)
    {
        $this->serviceBuildingLocation = $location;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Prototype", inversedBy="fuelStation")
     */
    private $Prototype;

    public function addPrototype(\LimeTrail\Bundle\Entity\Prototype $proto)
    {
        $proto->addFuelStation($this);
        $this->Prototype = $proto;

        return $this;
    }

    /**
     * Set Prototype
     *
     * @param  \LimeTrail\Bundle\Entity\Prototype $prototype
     * @return ProjectInformation
     */
    public function setPrototype(\LimeTrail\Bundle\Entity\Prototype $prototype = null)
    {
        $this->Prototype = $prototype;

        return $this;
    }

    /**
     * Get Prototype
     *
     * @return \LimeTrail\Bundle\Entity\Prototype
     */
    public function getPrototype()
    {
        return $this->Prototype;
    }

    /**
     * @var integer
     * uni-directional - Owning Side
     * @ORM\ManyToMany(targetEntity="ProjectInformation")
     * @ORM\JoinTable(name="store_fuel_projects",
     *      joinColumns={@ORM\JoinColumn(name="store_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="projects_id", referencedColumnName="id", unique=true)})
     */
     private $projects;

    public function addProject(\LimeTrail\Bundle\Entity\ProjectInformation $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }
}
