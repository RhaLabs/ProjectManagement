<?php

namespace LimeTrail\Bundle\Entity;

use APY\DataGridBundle\Grid\Mapping as GRID;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProjectInformation
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\ProjectinformationRepository")
 * @ORM\Table(name="project_information", indexes=
 {
 @ORM\Index(name="Seq_idx", columns={"Sequence"})
 }
 )
 */
class ProjectInformation extends \Application\GlobalBundle\Entity\BaseProjectInformation
{
    /**
     * @ORM\ManyToMany(targetEntity="Tenant", inversedBy="project")
     * @ORM\JoinTable(name="projects_tenants",
     joinColumns={
     @ORM\JoinColumn(name="project_id", referencedColumnName="id")},
     inverseJoinColumns={
     @ORM\JoinColumn(name="tenant_id", referencedColumnName="id")}
     )
     */
    protected $tenants;

    public function setTenant(\LimeTrail\Bundle\Entity\Tenant $tenant)
    {
        $this->tenants->add($tenant);

        $tenant->addProject($this);

        return $this;
    }

    public function setTenants($tenants)
    {
        if (is_array($tenants)) {
            foreach ($tenants as $tenant) {
                $this->setTenant($tenant);
            }

            return $this;
        }

        return $this->setTenants($tenants);
    }

    public function getTenants()
    {
        return $this->tenants;
    }

    /**
     * @ORM\ManyToOne(targetEntity="ProjectType", inversedBy="project")
     *
     * @GRID\Column(field="ProjectType.name", title="Project Type")
     */
    private $ProjectType;
    public function addProjectType(\LimeTrail\Bundle\Entity\ProjectType $Type)
    {
        $Type->addProject($this);
        $this->ProjectType = $Type;

        return $this;
    }

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="DevelopmentType", inversedBy="project")
     *
     * @GRID\Column(field="DevelopmentType.name", title="Development Type")
     */
    private $DevelopmentType;
    public function addDevelopmentType(\LimeTrail\Bundle\Entity\DevelopmentType $Type)
    {
        $Type->addProject($this);
        $this->DevelopmentType = $Type;

        return $this;
    }

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="DescriptionOfType", inversedBy="project")
     *
     * @GRID\Column(field="DescriptionOfType.name", title="Description Type")
     */
    private $DescriptionOfType;
    public function addDescriptionOfType(\LimeTrail\Bundle\Entity\DescriptionOfType $Type)
    {
        $Type->addProject($this);
        $this->DescriptionOfType = $Type;

        return $this;
    }

    /**
     * @var integer
     *              bi-directional - Owning Side
     * @ORM\ManyToOne(targetEntity="ProgramYear", inversedBy="project")
     *
     * @GRID\Column(field="ProgramYear.year", title="Program Year")
     */
    private $ProgramYear;
    public function addProgramYear(\LimeTrail\Bundle\Entity\ProgramYear $Year)
    {
        $Year->addProject($this);
        $this->ProgramYear = $Year;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="ProgramCategory", inversedBy="project")
     *
     * @GRID\Column(field="ProgramCategory.name", title="Program Category")
     */
    private $ProgramCategory;
    public function addProgramCategory(\LimeTrail\Bundle\Entity\ProgramCategory $category)
    {
        $category->addProject($this);
        $this->ProgramCategory = $category;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Prototype", inversedBy="project")
     *
     * @GRID\Column(field="Prototype.name", title="Prototype")
     */
    private $Prototype;
    public function addPrototype(\LimeTrail\Bundle\Entity\Prototype $proto)
    {
        $proto->addProject($this);
        $this->Prototype = $proto;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="ProjectStatus", inversedBy="project")
     *
     * @GRID\Column(field="ProjectStatus.name", title="Project Status")
     */
    private $ProjectStatus;
    public function addProjectStatus(\LimeTrail\Bundle\Entity\ProjectStatus $status)
    {
        $status->addProject($this);
        $this->ProjectStatus = $status;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToMany(targetEntity="Dates")
     * @ORM\JoinTable(name="projects_trident_dates",
     joinColumns={@ORM\JoinColumn(name="dates",
     referencedColumnName="id")},
     inverseJoinColumns={@ORM\JoinColumn(name="Trident_id",
     referencedColumnName="id")}
     )
     */
    private $dates;

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="DateOverride")
     */
    private $dateOverride;

    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="ProjectContacts", mappedBy="project")
     */
    private $contacts;
    public function addContact(\LimeTrail\Bundle\Entity\ProjectContacts $contact)
    {
        $this->contacts[] = $contact;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="aorContact")
     *
     * @GRID\Column(field="aorContact.firstName", title="Aor Contact")
     */
    private $aorContact;

    public function addAorContact(\LimeTrail\Bundle\Entity\Contact $contact)
    {
        $contact->addAorContact($this);

        $this->aorContact = $contact;

        return $this;
    }

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="\LimeTrail\Bundle\Entity\CodeReview", mappedBy="project")
     */
    private $becr;
    public function addBecr(\LimeTrail\Bundle\Entity\CodeReview $becr)
    {
        $this->becr = $becr;
    }

    public function __construct()
    {
        $this->dates = new ArrayCollection();
      //$this->dateOverride = new ArrayCollection();
      $this->contacts = new ArrayCollection();
        $this->changes = new ArrayCollection();
        $this->tenants = new ArrayCollection();

        $this->isChanged = null;
    }

    /**
     * Set ProjectType
     *
     * @param  \LimeTrail\Bundle\Entity\ProjectType $projectType
     * @return ProjectInformation
     */
    public function setProjectType(\LimeTrail\Bundle\Entity\ProjectType $projectType = null)
    {
        $this->ProjectType = $projectType;

        return $this;
    }

    /**
     * Get ProjectType
     *
     * @return \LimeTrail\Bundle\Entity\ProjectType
     */
    public function getProjectType()
    {
        return $this->ProjectType;
    }

    /**
     * Set DevelopmentType
     *
     * @param  \LimeTrail\Bundle\Entity\DevelopmentType $developmentType
     * @return ProjectInformation
     */
    public function setDevelopmentType(\LimeTrail\Bundle\Entity\DevelopmentType $developmentType = null)
    {
        $this->DevelopmentType = $developmentType;

        return $this;
    }

    /**
     * Get DevelopmentType
     *
     * @return \LimeTrail\Bundle\Entity\DevelopmentType
     */
    public function getDevelopmentType()
    {
        return $this->DevelopmentType;
    }

    /**
     * Set DescriptionOfType
     *
     * @param  \LimeTrail\Bundle\Entity\DescriptionOfType $descriptionOfType
     * @return ProjectInformation
     */
    public function setDescriptionOfType(\LimeTrail\Bundle\Entity\DescriptionOfType $descriptionOfType = null)
    {
        $this->DescriptionOfType = $descriptionOfType;

        return $this;
    }

    /**
     * Get DescriptionOfType
     *
     * @return \LimeTrail\Bundle\Entity\DescriptionOfType
     */
    public function getDescriptionOfType()
    {
        return $this->DescriptionOfType;
    }

    /**
     * Set ProgramYear
     *
     * @param  \LimeTrail\Bundle\Entity\ProgramYear $programYear
     * @return ProjectInformation
     */
    public function setProgramYear(\LimeTrail\Bundle\Entity\ProgramYear $programYear = null)
    {
        $this->ProgramYear = $programYear;

        return $this;
    }

    /**
     * Get ProgramYear
     *
     * @return \LimeTrail\Bundle\Entity\ProgramYear
     */
    public function getProgramYear()
    {
        return $this->ProgramYear;
    }

    /**
     * Remove ProgramYear
     */
    public function removeProgramYear(\LimeTrail\Bundle\Entity\ProgramYear $programYear)
    {
        $this->ProgramYear->removeElement($programYear);
    }

    /**
     * Set ProgramCategory
     *
     * @param  \LimeTrail\Bundle\Entity\ProgramCategory $programCategory
     * @return ProjectInformation
     */
    public function setProgramCategory(\LimeTrail\Bundle\Entity\ProgramCategory $programCategory = null)
    {
        $this->ProgramCategory = $programCategory;

        return $this;
    }

    /**
     * Get ProgramCategory
     *
     * @return \LimeTrail\Bundle\Entity\ProgramCategory
     */
    public function getProgramCategory()
    {
        return $this->ProgramCategory;
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
     * Set ProjectStatus
     *
     * @param  \LimeTrail\Bundle\Entity\ProjectStatus $projectStatus
     * @return ProjectInformation
     */
    public function setProjectStatus(\LimeTrail\Bundle\Entity\ProjectStatus $projectStatus = null)
    {
        $this->ProjectStatus = $projectStatus;

        return $this;
    }

    /**
     * Get ProjectStatus
     *
     * @return \LimeTrail\Bundle\Entity\ProjectStatus
     */
    public function getProjectStatus()
    {
        return $this->ProjectStatus;
    }

    /**
     * Add dates
     *
     * @param  \LimeTrail\Bundle\Entity\Dates $dates
     * @return ProjectInformation
     */
    public function addDate(\LimeTrail\Bundle\Entity\Dates $dates)
    {
        $this->dates[] = $dates;

        return $this;
    }

    /**
     * Remove dates
     *
     * @param \LimeTrail\Bundle\Entity\Dates $dates
     */
    public function removeDate(\LimeTrail\Bundle\Entity\Dates $dates)
    {
        $this->dates->removeElement($dates);
    }

    /**
     * Get dates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDateOverride()
    {
        return $this->dateOverride;
    }

    /**
     * Add dates
     *
     * @param  \LimeTrail\Bundle\Entity\Dates $dates
     * @return ProjectInformation
     */
    public function addDateOverride(\LimeTrail\Bundle\Entity\DateOverride $dates)
    {
        $this->dateOverride = $dates;

        return $this;
    }

    /**
     * Remove dates
     *
     * @param \LimeTrail\Bundle\Entity\Dates $dates
     */
    public function removeDateOverride(\LimeTrail\Bundle\Entity\DateOverride $dates)
    {
        $this->dateOverride->removeElement($dates);
    }

    /**
     * Get dates
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getDates()
    {
        return $this->dates;
    }

    /**
     * Set contact
     *
     * @param  \LimeTrail\Bundle\Entity\Contact $contact
     * @return ProjectInformation
     */
    public function setContact(\LimeTrail\Bundle\Entity\Contact $contact = null)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \LimeTrail\Bundle\Entity\Contact
     */
    public function getContacts()
    {
        return $this->contacts;
    }
    public function removeContact(\LimeTrail\Bundle\Entity\Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contact
     *
     * @return \LimeTrail\Bundle\Entity\Contact
     */
    public function getAorContact()
    {
        return $this->aorContact;
    }

    public function removeAorContact(\LimeTrail\Bundle\Entity\Contact $contact)
    {
        $this->aorContact->removeElement($contact);
    }

    /**
     * @var integer
     * @ORM\OneToMany(targetEntity="ProjectChangeInitiation", mappedBy="project")
     */
    private $projectChanges;

    public function addProjectChange(\LimeTrail\Bundle\Entity\ProjectChangeInitiation $change)
    {
        $this->changes[] = $change;

        return $this;
    }

    public function getChanges()
    {
        return $this->changes;
    }

    public function removeChange(\LimeTrail\Bundle\Entity\ProjectChangeInitiation $change)
    {
        $this->changes->removeElement($change);

        return $this;
    }

    public function __toString()
    {
        return get_class($this);
    }
}
