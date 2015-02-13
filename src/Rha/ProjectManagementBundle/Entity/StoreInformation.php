<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * StoreInformation
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\StoreInformationRepository")
 * @ORM\Table(name="store_information", indexes={@ORM\Index(name="idx", columns={"storeNumber"})})
 */
class StoreInformation extends \Application\GlobalBundle\Entity\BaseStoreInformation
{
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Rha\ProjectManagementBundle\Entity\StoreType", inversedBy="store")
     */
    private $storeType;
    public function addStoreType($storeType)
    {
        $storeType->addStore($this);
        $this->storeType = $storeType;

        return $this;
    }
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Address", inversedBy="store")
     */
    private $address;
    public function addAddress(\Rha\ProjectManagementBundle\Entity\Address $address)
    {
        $address->addStore($this);
        $this->address = $address;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="StreetIntersection", inversedBy="store")
     */
    private $streetIntersection;
    public function addStreetIntersection(\Rha\ProjectManagementBundle\Entity\StreetIntersection $intersection)
    {
        $intersection->addStore($this);
        $this->streetIntersection = $intersection;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="City", inversedBy="store")
     */
    private $city;
    public function addCity(\Rha\ProjectManagementBundle\Entity\City $city)
    {
        $city->addStore($this);
        $this->city = $city;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Zip", inversedBy="store")
     */
    private $zip;
    public function addZip(\Rha\ProjectManagementBundle\Entity\Zip $zipcode)
    {
        $zipcode->addStore($this);
        $this->zip = $zipcode;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="County", inversedBy="store")
     */
    private $county;
    public function addCounty(\Rha\ProjectManagementBundle\Entity\County $county)
    {
        $county->addStore($this);
        $this->county = $county;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Division", inversedBy="store")
     */
    private $division;
    public function addDivision(\Rha\ProjectManagementBundle\Entity\Division $div)
    {
        $div->addStore($this);
        $this->division = $div;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Region", inversedBy="store")
     */
    private $region;
    public function addRegion(\Rha\ProjectManagementBundle\Entity\Region $region)
    {
        $region->addStore($this);
        $this->region = $region;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="State", inversedBy="store")
     */
    private $state;
    public function addState(\Rha\ProjectManagementBundle\Entity\State $state)
    {
        $state->addStore($this);
        $this->state = $state;

        return $this;
    }

     /**
      * @var integer
      * uni-directional - Owning Side
      * @ORM\ManyToMany(targetEntity="ProjectInformation")
      * @ORM\JoinTable(name="store_projects",
      *      joinColumns={@ORM\JoinColumn(name="store_id", referencedColumnName="id")},
      *      inverseJoinColumns={@ORM\JoinColumn(name="projects_id", referencedColumnName="id", unique=true)})
      */
     private $projects;
    public function addProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $project)
    {
        $this->projects[] = $project;

        return $this;
    }

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    /**
     * Set storeType
     *
     * @param  \Rha\ProjectManagementBundle\Entity\StoreType $storeType
     * @return StoreInformation
     */
    public function setStoreType($storeType = null)
    {
        $this->storeType = $storeType;

        return $this;
    }

    /**
     * Get storeType
     *
     * @return \Rha\ProjectManagementBundle\Entity\StoreType
     */
    public function getStoreType()
    {
        return $this->storeType;
    }

    /**
     * Set address
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Address $address
     * @return StoreInformation
     */
    public function setAddress(\Rha\ProjectManagementBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \Rha\ProjectManagementBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set streetIntersection
     *
     * @param  \Rha\ProjectManagementBundle\Entity\StreetIntersection $streetIntersection
     * @return StoreInformation
     */
    public function setStreetIntersection(\Rha\ProjectManagementBundle\Entity\StreetIntersection $streetIntersection = null)
    {
        $this->streetIntersection = $streetIntersection;

        return $this;
    }

    /**
     * Get streetIntersection
     *
     * @return \Rha\ProjectManagementBundle\Entity\StreetIntersection
     */
    public function getStreetIntersection()
    {
        return $this->streetIntersection;
    }

    /**
     * Set city
     *
     * @param  \Rha\ProjectManagementBundle\Entity\City $city
     * @return StoreInformation
     */
    public function setCity(\Rha\ProjectManagementBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Rha\ProjectManagementBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zip
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Zip $zip
     * @return StoreInformation
     */
    public function setZip(\Rha\ProjectManagementBundle\Entity\Zip $zip = null)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return \Rha\ProjectManagementBundle\Entity\Zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set county
     *
     * @param  \Rha\ProjectManagementBundle\Entity\County $county
     * @return StoreInformation
     */
    public function setCounty(\Rha\ProjectManagementBundle\Entity\County $county = null)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return \Rha\ProjectManagementBundle\Entity\County
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set division
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Division $division
     * @return StoreInformation
     */
    public function setDivision(\Rha\ProjectManagementBundle\Entity\Division $division = null)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * Get division
     *
     * @return \Rha\ProjectManagementBundle\Entity\Division
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * Set region
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Region $region
     * @return StoreInformation
     */
    public function setRegion(\Rha\ProjectManagementBundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \Rha\ProjectManagementBundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set state
     *
     * @param  \Rha\ProjectManagementBundle\Entity\State $state
     * @return StoreInformation
     */
    public function setState(\Rha\ProjectManagementBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Rha\ProjectManagementBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Remove projects
     *
     * @param \Rha\ProjectManagementBundle\Entity\ProjectInformation $projects
     */
    public function removeProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }
}
