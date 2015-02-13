<?php

namespace LimeTrail\Bundle\Entity;

use APY\DataGridBundle\Grid\Mapping as GRID;
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
 *
 * @GRID\Column(id="projectcontacts", title="Contacts")
 * @GRID\Column(id="projectchanges", title="Changes")
 * @GRID\Column(id="tenants", title="Tenants")
 * @GRID\Column(id="dates", title="Dates", groups={"project"})
 */
class StoreInformation extends \Application\GlobalBundle\Entity\BaseStoreInformation
{
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="LimeTrail\Bundle\Entity\StoreType", inversedBy="store")
     *
     * @GRID\Column(field="storeType.name", title="Store Type", groups={"store_information", "trident", "myProjects", "projects_by_manager", "shells"})
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
     *
     * @GRID\Column(field="address.address", title="Address", size=200, groups={"store_information"})
     * @GRID\Column(field="address.longitude", title="longitude", groups={"store_information"})
     * @GRID\Column(field="address.latitude", title="latitude", groups={"store_information"})
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
     *
     * @GRID\Column(field="streetIntersection.name", title="Street Intersection", size=300, groups={"store_information"})
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
     *
     * @GRID\Column(field="city.name", title="City", size=150, groups={"store_information", "trident", "myProjects", "projects_by_manager", "shells"})
     * @GRID\Column(field="city.id", title="CityId", visible=false, groups={"store_information", "trident", "myProjects", "projects_by_manager", "shells"})
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
     *
     * @GRID\Column(field="zip.zipcode", title="Zip Code", groups={"store_information"})
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
     *
     * @GRID\Column(field="county.name", title="County", groups={"store_information", "trident"})
     * @GRID\Column(field="county.id", title="CountyId", visible=false, groups={"store_information", "trident"})
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
     *
     * @GRID\Column(field="division.name", title="Division", groups={"store_information"})
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
     *
     * @GRID\Column(field="region.name", title="Region", groups={"store_information"})
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
     *
     * @GRID\Column(field="state.abbreviation", title="State", groups={"store_information", "trident", "myProjects", "projects_by_manager", "shells"})
     * @GRID\Column(field="state.id", title="StateId", visible=false, groups={"store_information", "trident", "myProjects", "projects_by_manager", "shells"})
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
     *              uni-directional - Owning Side
     * @ORM\ManyToMany(targetEntity="ProjectInformation")
     * @ORM\JoinTable(name="store_projects",
     *              joinColumns={@ORM\JoinColumn(name="store_id", referencedColumnName="id")},
     *              inverseJoinColumns={@ORM\JoinColumn(name="projects_id", referencedColumnName="id", unique=true)})
     *
     * @GRID\Column(field="projects.id", title="project_id", visible=false)
     * @GRID\Column(field="projects.Sequence", title="Sequence", groups={"project_information", "trident", "myProjects", "projects_by_manager", "shells"})
     * @GRID\Column(field="projects.projectNumber", title="RHA Project Number", groups={"project_information", "trident", "myProjects", "projects_by_manager", "shells"})
     * @GRID\Column(field="projects.canonicalName", title="Project Name", size=250, groups={"project_information", "trident", "myProjects", "projects_by_manager", "shells"})
     * @GRID\Column(field="projects.DescriptionOfType.name", title="Description", groups={"project_information"})
     * @GRID\Column(field="projects.projectPhase", title="Project Phase", groups={"project_information"})
     * @GRID\Column(field="projects.Prototype.name", title="Prototype", groups={"project_information", "trident", "myProjects", "projects_by_manager", "shells"})
     * @GRID\Column(field="projects.ProgramCategory.name", title="Program Category", groups={"project_information"})
     * @GRID\Column(field="projects.ProjectType.name", title="Project Type", groups={"project_information", "trident", "myProjects", "projects_by_manager", "shells"})
     * @GRID\Column(field="projects.DevelopmentType.name", title="Development Type", groups={"project_information", "trident", "projects_by_manager", "shells"})
     * @GRID\Column(field="projects.ProjectStatus.name", title="Project Status", groups={"project_information", "trident", "projects_by_manager", "shells"})
     * @GRID\Column(field="projects.confidential", title="Confidential", groups={"project_information"})
     * @GRID\Column(field="projects.combo", title="Combo Site", groups={"project_information"})
     * @GRID\Column(field="projects.manageSitesDifferent", title="Manage Sites Different", groups={"project_information"})
     * @GRID\Column(field="projects.sap", title="SAP", groups={"project_information", "trident"})
     * @GRID\Column(field="projects.ProgramYear.year", title="Program Year", groups={"project_information", "trident", "projects_by_manager"})
     * @GRID\Column(field="projects.protoSize", title="Proto Size", groups={"project_information"})
     * @GRID\Column(field="projects.storeSquareFootage", title="Store Square Footage", groups={"project_information"})
     * @GRID\Column(field="projects.increaseSquareFootage", title="Increase Square Footage", groups={"project_information"})
     * @GRID\Column(field="projects.prjTotalSquareFootage", title="Project Total Square Footage", groups={"project_information"})
     * @GRID\Column(field="projects.actTotalSquareFootage", title="Actual Total Square Footage", groups={"project_information"})
     * @GRID\Column(field="projects.cecComm", title="Civil Comments", groups={"project_information"})
     * @GRID\Column(field="projects.cOfOComm", title="Comments for Cert. Occupancy", groups={"project_information"})
     * @GRID\Column(field="projects.aorComm", title="Arechitect Comments", groups={"project_information"})
     * @GRID\Column(field="projects.closeoutComm", title="Closeout Comments", groups={"project_information"})
     * @GRID\Column(field="projects.podComm", title="POD Comments", groups={"project_information"})
     * @GRID\Column(field="projects.isChanged", visible=false, title="isChanged", groups={"trident", "myProjects", "shells"})
     *
     * @GRID\Column(field="projects.aorContact.firstName", title="Aor Contact First Name", groups={"project_information", "trident"})
     * @GRID\Column(field="projects.aorContact.lastName", title="Aor Contact Last Name", groups={"project_information", "trident"})
     *
     * @GRID\Column(field="projects.dates.recAct", type="datetime", format="m/d/Y", title="REC Actual", groups={"trident"})
     * @GRID\Column(field="projects.dates.recPrj", type="datetime", format="m/d/Y", title="REC Projected", groups={"trident"})
     * @GRID\Column(field="projects.dates.intClosingAct", type="datetime", format="m/d/Y", title="Internal Closing Actual", groups={"trident"})
     * @GRID\Column(field="projects.dates.intClosingPrj", type="datetime", format="m/d/Y", title="Internal Closing Projected", groups={"trident"})
     * @GRID\Column(field="projects.dates.desCivilAct", type="datetime", format="m/d/Y", title="Design Civil Actual", groups={"trident"})
     * @GRID\Column(field="projects.dates.desCivilPrj", type="datetime", format="m/d/Y", title="Design Civil Projected", groups={"trident"})
     * @GRID\Column(field="projects.dates.cwaAct", type="datetime", format="m/d/Y", title="CWA Actual", groups={"trident"})
     * @GRID\Column(field="projects.dates.cwaPrj", type="datetime", format="m/d/Y", title="CWA Projected", groups={"trident"})
     * @GRID\Column(field="projects.dates.pwoAct", type="datetime", format="m/d/Y", title="PWO Actual", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.pwoPrj", type="datetime", format="m/d/Y", title="PWO Projected", groups={"trident", "myProjects", "shells"})
     * @GRID\Column(field="projects.dates.pwoIdAct", type="datetime", format="m/d/Y", title="PWO Id Actual", groups={"trident"})
     * @GRID\Column(field="projects.dates.pwoIdPrj", type="datetime", format="m/d/Y", title="PWO Id Projected", groups={"trident", "shells"})
     * @GRID\Column(field="projects.dates.otpAct", type="datetime", format="m/d/Y", title="OTP Actual", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.otpPrj", type="datetime", format="m/d/Y", title="OTP Projected", groups={"trident", "myProjects", "shells"})
     * @GRID\Column(field="projects.dates.archPermitAct", type="datetime", format="m/d/Y", title="Architectural Permit Actual", groups={"trident"})
     * @GRID\Column(field="projects.dates.archPermitPrj", type="datetime", format="m/d/Y", title="Architectural Permit Projected", groups={"trident"})
     * @GRID\Column(field="projects.dates.otbAct", type="datetime", format="m/d/Y", title="OTB Actual", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.otbPrj", type="datetime", format="m/d/Y", title="OTB Projected", groups={"trident", "myProjects", "shells"})
     * @GRID\Column(field="projects.dates.bidDateAct", type="datetime", format="m/d/Y", title="Bid Date Actual", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.bidDatePrj", type="datetime", format="m/d/Y", title="Bid Date Projected", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.awardAct", type="datetime", format="m/d/Y", title="Award Actual", groups={"trident"})
     * @GRID\Column(field="projects.dates.awardPrj", type="datetime", format="m/d/Y", title="Award Projected", groups={"trident"})
     * @GRID\Column(field="projects.dates.constrStartAct", type="datetime", format="m/d/Y", title="Construction Start Actual", groups={"trident"})
     * @GRID\Column(field="projects.dates.constrStartPrj", type="datetime", format="m/d/Y", title="Construction Start Projected", groups={"trident"})
     * @GRID\Column(field="projects.dates.possAct", type="datetime", format="m/d/Y", title="Possession Actual", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.possPrj", type="datetime", format="m/d/Y", title="Possession Projected", groups={"trident", "myProjects", "shells"})
     * @GRID\Column(field="projects.dates.goAct", type="datetime", format="m/d/Y", title="Grand Opening Actual", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.goPrj", type="datetime", format="m/d/Y", title="Grand Opening Projected", groups={"trident", "myProjects", "shells"})
     * @GRID\Column(field="projects.dates.runDate", type="datetime", format="m/d/Y", title="Run Date", groups={"trident", "projects_by_manager", "shells"})
     *
     * @GRID\Column(field="projects.dates.recActChanged", type="boolean", visible=false, format="m/d/Y", title="recAct", groups={"trident"})
     * @GRID\Column(field="projects.dates.recPrjChanged", type="boolean", visible=false, format="m/d/Y", title="recPrj", groups={"trident"})
     * @GRID\Column(field="projects.dates.intClosingActChanged", type="boolean", visible=false, format="m/d/Y", title="intClosingAct", groups={"trident"})
     * @GRID\Column(field="projects.dates.intClosingPrjChanged", type="boolean", visible=false, format="m/d/Y", title="intClosingPrj", groups={"trident"})
     * @GRID\Column(field="projects.dates.desCivilActChanged", type="boolean", visible=false, format="m/d/Y", title="desCivilAct", groups={"trident"})
     * @GRID\Column(field="projects.dates.desCivilPrjChanged", type="boolean", visible=false, format="m/d/Y", title="desCivilPrj", groups={"trident"})
     * @GRID\Column(field="projects.dates.cwaActChanged", type="boolean", visible=false, format="m/d/Y", title="cwaAct", groups={"trident"})
     * @GRID\Column(field="projects.dates.cwaPrjChanged", type="boolean", visible=false, format="m/d/Y", title="cwaPrj", groups={"trident"})
     * @GRID\Column(field="projects.dates.pwoActChanged", type="boolean", visible=false, format="m/d/Y", title="pwoAct", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.pwoPrjChanged", type="boolean", visible=false, format="m/d/Y", title="pwoPrj", groups={"trident", "myProjects", "shells"})
     * @GRID\Column(field="projects.dates.pwoIdActChanged", type="boolean", visible=false, format="m/d/Y", title="pwoIdAct", groups={"trident"})
     * @GRID\Column(field="projects.dates.pwoIdPrjChanged", type="boolean", visible=false, format="m/d/Y", title="pwoIdPrj", groups={"trident", "shells"})
     * @GRID\Column(field="projects.dates.otpActChanged", type="boolean", visible=false, format="m/d/Y", title="otpAct", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.otpPrjChanged", type="boolean", visible=false, format="m/d/Y", title="otpPrj", groups={"trident", "myProjects", "shells"})
     * @GRID\Column(field="projects.dates.archPermitActChanged", type="boolean", visible=false, format="m/d/Y", title="archPermitAct", groups={"trident"})
     * @GRID\Column(field="projects.dates.archPermitPrjChanged", type="boolean", visible=false, format="m/d/Y", title="archPermitPrj", groups={"trident"})
     * @GRID\Column(field="projects.dates.otbActChanged", type="boolean", visible=false, format="m/d/Y", title="otbAct", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.otbPrjChanged", type="boolean", visible=false, format="m/d/Y", title="otbPrj", groups={"trident", "myProjects", "shells"})
     * @GRID\Column(field="projects.dates.bidDateActChanged", type="boolean", visible=false, format="m/d/Y", title="bidDateAct", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.bidDatePrjChanged", type="boolean", visible=false, format="m/d/Y", title="bidDatePrj", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.awardActChanged", type="boolean", visible=false, format="m/d/Y", title="awardAct", groups={"trident"})
     * @GRID\Column(field="projects.dates.awardPrjChanged", type="boolean", visible=false, format="m/d/Y", title="awardPrj", groups={"trident"})
     * @GRID\Column(field="projects.dates.constrStartActChanged", type="boolean", visible=false, format="m/d/Y", title="constrStartAct", groups={"trident"})
     * @GRID\Column(field="projects.dates.constrStartPrjChanged", type="boolean", visible=false, format="m/d/Y", title="constrStartPrj", groups={"trident"})
     * @GRID\Column(field="projects.dates.possActChanged", type="boolean", visible=false, format="m/d/Y", title="possAct", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.possPrjChanged", type="boolean", visible=false, format="m/d/Y", title="possPrj", groups={"trident", "myProjects", "shells"})
     * @GRID\Column(field="projects.dates.goActChanged", type="boolean", visible=false, format="m/d/Y", title="goAct", groups={"trident", "myProjects"})
     * @GRID\Column(field="projects.dates.goPrjChanged", type="boolean", visible=false, format="m/d/Y", title="goPrj", groups={"trident", "myProjects", "shells"})
     *
     * @GRID\Column(field="projects.contacts.contact.email", visible=false, title="email", groups={"myProjects"})
     * @GRID\Column(field="projects.contacts.contact.firstName", visible=true, title="First Name", groups={"projects_by_manager"})
     * @GRID\Column(field="projects.contacts.contact.lastName", visible=true, title="Last Name", groups={"projects_by_manager"})
     * @GRID\Column(field="projects.contacts.jobrole.jobRole", visible=false, title="jobrole", groups={"projects_by_manager"})
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
