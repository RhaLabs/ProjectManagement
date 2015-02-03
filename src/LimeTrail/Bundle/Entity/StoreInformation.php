<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * StoreInformation
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\StoreInformationRepository")
 * @ORM\Table(name="store_information",
    indexes=
        {
            @ORM\Index(name="idx", columns={"storeNumber"})
        }
    )
 */
class StoreInformation extends \Application\GlobalBundle\Entity\BaseStoreInformation
{
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="LimeTrail\Bundle\Entity\StoreType", inversedBy="store")
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
    public function addAddress(\LimeTrail\Bundle\Entity\Address $address)
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
    public function addStreetIntersection(\LimeTrail\Bundle\Entity\StreetIntersection $intersection)
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
    public function addCity(\LimeTrail\Bundle\Entity\City $city)
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
    public function addZip(\LimeTrail\Bundle\Entity\Zip $zipcode)
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
    public function addCounty(\LimeTrail\Bundle\Entity\County $county)
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
    public function addDivision(\LimeTrail\Bundle\Entity\Division $div)
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
    public function addRegion(\LimeTrail\Bundle\Entity\Region $region)
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
    public function addState(\LimeTrail\Bundle\Entity\State $state)
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
    public function addProject(\LimeTrail\Bundle\Entity\ProjectInformation $project)
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
     * @param  \LimeTrail\Bundle\Entity\StoreType $storeType
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
     * @return \LimeTrail\Bundle\Entity\StoreType
     */
    public function getStoreType()
    {
        return $this->storeType;
    }

    /**
     * Set address
     *
     * @param  \LimeTrail\Bundle\Entity\Address $address
     * @return StoreInformation
     */
    public function setAddress(\LimeTrail\Bundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \LimeTrail\Bundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set streetIntersection
     *
     * @param  \LimeTrail\Bundle\Entity\StreetIntersection $streetIntersection
     * @return StoreInformation
     */
    public function setStreetIntersection(\LimeTrail\Bundle\Entity\StreetIntersection $streetIntersection = null)
    {
        $this->streetIntersection = $streetIntersection;

        return $this;
    }

    /**
     * Get streetIntersection
     *
     * @return \LimeTrail\Bundle\Entity\StreetIntersection
     */
    public function getStreetIntersection()
    {
        return $this->streetIntersection;
    }

    /**
     * Set city
     *
     * @param  \LimeTrail\Bundle\Entity\City $city
     * @return StoreInformation
     */
    public function setCity(\LimeTrail\Bundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \LimeTrail\Bundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set zip
     *
     * @param  \LimeTrail\Bundle\Entity\Zip $zip
     * @return StoreInformation
     */
    public function setZip(\LimeTrail\Bundle\Entity\Zip $zip = null)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return \LimeTrail\Bundle\Entity\Zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Set county
     *
     * @param  \LimeTrail\Bundle\Entity\County $county
     * @return StoreInformation
     */
    public function setCounty(\LimeTrail\Bundle\Entity\County $county = null)
    {
        $this->county = $county;

        return $this;
    }

    /**
     * Get county
     *
     * @return \LimeTrail\Bundle\Entity\County
     */
    public function getCounty()
    {
        return $this->county;
    }

    /**
     * Set division
     *
     * @param  \LimeTrail\Bundle\Entity\Division $division
     * @return StoreInformation
     */
    public function setDivision(\LimeTrail\Bundle\Entity\Division $division = null)
    {
        $this->division = $division;

        return $this;
    }

    /**
     * Get division
     *
     * @return \LimeTrail\Bundle\Entity\Division
     */
    public function getDivision()
    {
        return $this->division;
    }

    /**
     * Set region
     *
     * @param  \LimeTrail\Bundle\Entity\Region $region
     * @return StoreInformation
     */
    public function setRegion(\LimeTrail\Bundle\Entity\Region $region = null)
    {
        $this->region = $region;

        return $this;
    }

    /**
     * Get region
     *
     * @return \LimeTrail\Bundle\Entity\Region
     */
    public function getRegion()
    {
        return $this->region;
    }

    /**
     * Set state
     *
     * @param  \LimeTrail\Bundle\Entity\State $state
     * @return StoreInformation
     */
    public function setState(\LimeTrail\Bundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \LimeTrail\Bundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Remove projects
     *
     * @param \LimeTrail\Bundle\Entity\ProjectInformation $projects
     */
    public function removeProject(\LimeTrail\Bundle\Entity\ProjectInformation $projects)
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
