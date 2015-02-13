<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProjectInformation
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\ProjectinformationRepository")
 * @ORM\Table(name="project_information", indexes=
 {
 @ORM\Index(name="Seq_idx", columns={"Sequence"})
 }
 )
 */
class ProjectInformation extends \Application\GlobalBundle\Entity\BaseProjectInformation
{
    /**
     * @ORM\ManyToOne(targetEntity="ProjectType", inversedBy="project")
     */
    private $ProjectType;
    public function addProjectType(\Rha\ProjectManagementBundle\Entity\ProjectType $Type)
    {
        $Type->addProject($this);
        $this->ProjectType = $Type;

        return $this;
    }

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="DevelopmentType", inversedBy="project")
     */
    private $DevelopmentType;
    public function addDevelopmentType(\Rha\ProjectManagementBundle\Entity\DevelopmentType $Type)
    {
        $Type->addProject($this);
        $this->DevelopmentType = $Type;

        return $this;
    }

    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="DescriptionOfType", inversedBy="project")
     */
    private $DescriptionOfType;
    public function addDescriptionOfType(\Rha\ProjectManagementBundle\Entity\DescriptionOfType $Type)
    {
        $Type->addProject($this);
        $this->DescriptionOfType = $Type;

        return $this;
    }

    /**
     * @var integer
     *              bi-directional - Owning Side
     * @ORM\ManyToOne(targetEntity="ProgramYear", inversedBy="project")
     */
    private $ProgramYear;
    public function addProgramYear(\Rha\ProjectManagementBundle\Entity\ProgramYear $Year)
    {
        $Year->addProject($this);
        $this->ProgramYear = $Year;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="ProgramCategory", inversedBy="project")
     */
    private $ProgramCategory;
    public function addProgramCategory(\Rha\ProjectManagementBundle\Entity\ProgramCategory $category)
    {
        $category->addProject($this);
        $this->ProgramCategory = $category;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Prototype", inversedBy="project")
     */
    private $Prototype;
    public function addPrototype(\Rha\ProjectManagementBundle\Entity\Prototype $proto)
    {
        $proto->addProject($this);
        $this->Prototype = $proto;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="ProjectStatus", inversedBy="project")
     */
    private $ProjectStatus;
    public function addProjectStatus(\Rha\ProjectManagementBundle\Entity\ProjectStatus $status)
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
    public function addContact(\Rha\ProjectManagementBundle\Entity\ProjectContacts $contact)
    {
        $this->contacts[] = $contact;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="aorContact")
     */
    private $aorContact;

    public function addAorContact(\Rha\ProjectManagementBundle\Entity\Contact $contact)
    {
        $contact->addAorContact($this);

        $this->aorContact = $contact;

        return $this;
    }

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="\Rha\ProjectManagementBundle\Entity\CodeReview", mappedBy="project")
     */
    private $becr;
    public function addBecr(\Rha\ProjectManagementBundle\Entity\CodeReview $becr)
    {
        $this->becr = $becr;

        return $this;
    }

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="\Rha\ProjectManagementBundle\Entity\ProjectCriteria", mappedBy="project")
     */
    private $projectCriteria;
    public function addProjectCriteria(\Rha\ProjectManagementBundle\Entity\ProjectCriteria $value)
    {
        $this->projectCriteria = $value;

        return $this;
    }

    public function getProjectCriteria()
    {
        return $this->projectCriteria;
    }

    public function __construct()
    {
        $this->dates = new ArrayCollection();
      //$this->dateOverride = new ArrayCollection();
      $this->contacts = new ArrayCollection();

        $this->isChanged = null;
    }

    /**
     * Set ProjectType
     *
     * @param  \Rha\ProjectManagementBundle\Entity\ProjectType $projectType
     * @return ProjectInformation
     */
    public function setProjectType(\Rha\ProjectManagementBundle\Entity\ProjectType $projectType = null)
    {
        $this->ProjectType = $projectType;

        return $this;
    }

    /**
     * Get ProjectType
     *
     * @return \Rha\ProjectManagementBundle\Entity\ProjectType
     */
    public function getProjectType()
    {
        return $this->ProjectType;
    }

    /**
     * Set DevelopmentType
     *
     * @param  \Rha\ProjectManagementBundle\Entity\DevelopmentType $developmentType
     * @return ProjectInformation
     */
    public function setDevelopmentType(\Rha\ProjectManagementBundle\Entity\DevelopmentType $developmentType = null)
    {
        $this->DevelopmentType = $developmentType;

        return $this;
    }

    /**
     * Get DevelopmentType
     *
     * @return \Rha\ProjectManagementBundle\Entity\DevelopmentType
     */
    public function getDevelopmentType()
    {
        return $this->DevelopmentType;
    }

    /**
     * Set DescriptionOfType
     *
     * @param  \Rha\ProjectManagementBundle\Entity\DescriptionOfType $descriptionOfType
     * @return ProjectInformation
     */
    public function setDescriptionOfType(\Rha\ProjectManagementBundle\Entity\DescriptionOfType $descriptionOfType = null)
    {
        $this->DescriptionOfType = $descriptionOfType;

        return $this;
    }

    /**
     * Get DescriptionOfType
     *
     * @return \Rha\ProjectManagementBundle\Entity\DescriptionOfType
     */
    public function getDescriptionOfType()
    {
        return $this->DescriptionOfType;
    }

    /**
     * Set ProgramYear
     *
     * @param  \Rha\ProjectManagementBundle\Entity\ProgramYear $programYear
     * @return ProjectInformation
     */
    public function setProgramYear(\Rha\ProjectManagementBundle\Entity\ProgramYear $programYear = null)
    {
        $this->ProgramYear = $programYear;

        return $this;
    }

    /**
     * Get ProgramYear
     *
     * @return \Rha\ProjectManagementBundle\Entity\ProgramYear
     */
    public function getProgramYear()
    {
        return $this->ProgramYear;
    }

    /**
     * Remove ProgramYear
     */
    public function removeProgramYear(\Rha\ProjectManagementBundle\Entity\ProgramYear $programYear)
    {
        $this->ProgramYear->removeElement($programYear);
    }

    /**
     * Set ProgramCategory
     *
     * @param  \Rha\ProjectManagementBundle\Entity\ProgramCategory $programCategory
     * @return ProjectInformation
     */
    public function setProgramCategory(\Rha\ProjectManagementBundle\Entity\ProgramCategory $programCategory = null)
    {
        $this->ProgramCategory = $programCategory;

        return $this;
    }

    /**
     * Get ProgramCategory
     *
     * @return \Rha\ProjectManagementBundle\Entity\ProgramCategory
     */
    public function getProgramCategory()
    {
        return $this->ProgramCategory;
    }

    /**
     * Set Prototype
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Prototype $prototype
     * @return ProjectInformation
     */
    public function setPrototype(\Rha\ProjectManagementBundle\Entity\Prototype $prototype = null)
    {
        $this->Prototype = $prototype;

        return $this;
    }

    /**
     * Get Prototype
     *
     * @return \Rha\ProjectManagementBundle\Entity\Prototype
     */
    public function getPrototype()
    {
        return $this->Prototype;
    }

    /**
     * Set ProjectStatus
     *
     * @param  \Rha\ProjectManagementBundle\Entity\ProjectStatus $projectStatus
     * @return ProjectInformation
     */
    public function setProjectStatus(\Rha\ProjectManagementBundle\Entity\ProjectStatus $projectStatus = null)
    {
        $this->ProjectStatus = $projectStatus;

        return $this;
    }

    /**
     * Get ProjectStatus
     *
     * @return \Rha\ProjectManagementBundle\Entity\ProjectStatus
     */
    public function getProjectStatus()
    {
        return $this->ProjectStatus;
    }

    /**
     * Add dates
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Dates $dates
     * @return ProjectInformation
     */
    public function addDate(\Rha\ProjectManagementBundle\Entity\Dates $dates)
    {
        $this->dates[] = $dates;

        return $this;
    }

    /**
     * Remove dates
     *
     * @param \Rha\ProjectManagementBundle\Entity\Dates $dates
     */
    public function removeDate(\Rha\ProjectManagementBundle\Entity\Dates $dates)
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
     * @param  \Rha\ProjectManagementBundle\Entity\Dates $dates
     * @return ProjectInformation
     */
    public function addDateOverride(\Rha\ProjectManagementBundle\Entity\DateOverride $dates)
    {
        $this->dateOverride = $dates;

        return $this;
    }

    /**
     * Remove dates
     *
     * @param \Rha\ProjectManagementBundle\Entity\Dates $dates
     */
    public function removeDateOverride(\Rha\ProjectManagementBundle\Entity\DateOverride $dates)
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
     * @param  \Rha\ProjectManagementBundle\Entity\Contact $contact
     * @return ProjectInformation
     */
    public function setContact(\Rha\ProjectManagementBundle\Entity\Contact $contact = null)
    {
        $this->contacts[] = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \Rha\ProjectManagementBundle\Entity\Contact
     */
    public function getContacts()
    {
        return $this->contacts;
    }
    public function removeContact(\Rha\ProjectManagementBundle\Entity\Contact $contact)
    {
        $this->contacts->removeElement($contact);
    }

    /**
     * Get contact
     *
     * @return \Rha\ProjectManagementBundle\Entity\Contact
     */
    public function getAorContact()
    {
        return $this->aorContact;
    }

    public function removeAorContact(\Rha\ProjectManagementBundle\Entity\Contact $contact)
    {
        $this->aorContact->removeElement($contact);
    }
}
