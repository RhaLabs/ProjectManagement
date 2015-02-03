<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="project_criteria", indexes=
        {
          @ORM\Index(name="geo_idx", columns={"geoTechnical"}),
          @ORM\Index(name="wss_idx", columns={"waterStudy"}),
          @ORM\Index(name="fuel_idx", columns={"fuelStudy"}),
          @ORM\Index(name="dc_idx", columns={"designCivilDocuments"}),
          @ORM\Index(name="ren_idx", columns={"renderings"}),
          @ORM\Index(name="plan_idx", columns={"merchandisePlan"}),
          @ORM\Index(name="level_idx", columns={"buildingDesignLevel"})
        }
      )
 */
class ProjectCriteria extends \Application\GlobalBundle\Entity\BaseEntity
{
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="ArchitectOfRecord")
     */
    protected $ArchitectOfRecord;

    public function addArchitectOfRecord(\Rha\ProjectManagementBundle\Entity\Contact $contact)
    {
        $contact->addArchitectOfRecord($this);

        $this->ArchitectOfRecord = $contact;

        return $this;
    }

    public function getArchitectOfRecord()
    {
        return $this->ArchitectOfRecord;
    }

    public function setArchitectOfRecord(\Rha\ProjectManagementBundle\Entity\Contact $contact)
    {
        return $this->addArchitectOfRecord($contact);
    }

    public function removeArchitectOfRecord(\Rha\ProjectManagementBundle\Entity\Contact $contact)
    {
        $this->ArchitectOfRecord->removeElement($contact);
    }

    /**
     * @ORM\OneToOne(targetEntity="ProjectInformation", inversedBy="projectCriteria")
     */
    protected $project;

    public function addProject(\Application\GlobalBundle\Entity\BaseProjectInformation $project)
    {
        $project->addProjectCriteria($this);

        $this->project = $project;

        return $this;
    }

    public function getProject()
    {
        return $this->project;
    }

    public function setProject(\Application\GlobalBundle\Entity\BaseProjectInformation $project)
    {
        return $this->addProject($project);
    }

    public function removeProject(\Application\GlobalBundle\Entity\BaseProjectInformation $project)
    {
        $this->project->removeElement($project);
    }

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $geoTechnical;

    public function getGeoTechnical()
    {
        return $this->geoTechnical;
    }

    public function setGeoTechnical($date)
    {
        $this->geoTechnical = $date;

        return $this;
    }

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $waterStudy;

    public function getWaterStudy()
    {
        return $this->waterStudy;
    }

    public function setWaterStudy($date)
    {
        $this->waterStudy = $date;

        return $this;
    }

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $fuelStudy;

    public function getFuelStudy()
    {
        return $this->fuelStudy;
    }

    public function setFuelStudy($date)
    {
        $this->fuelStudy = $date;

        return $this;
    }

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $designCivilDocuments;

    public function getDesignCivilDocuments()
    {
        return $this->designCivilDocuments;
    }

    public function setDesignCivilDocuments($date)
    {
        $this->designCivilDocuments = $date;

        return $this;
    }

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $renderings;

    public function getRenderings()
    {
        return $this->renderings;
    }

    public function setRenderings($date)
    {
        $this->renderings = $date;

        return $this;
    }

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $merchandisePlan;

    public function getMerchandisePlan()
    {
        return $this->merchandisePlan;
    }

    public function setMerchandisePlan($date)
    {
        $this->merchandisePlan = $date;

        return $this;
    }

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    protected $buildingDesignLevel;

    public function getBuildingDesignLevel()
    {
        return $this->buildingDesignLevel;
    }

    public function setBuildingDesignLevel($value)
    {
        $this->buildingDesignLevel = $value;

        return $this;
    }

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="PreDesign")
     */
    protected $predesign;

    public function addPredesign(\Rha\ProjectManagementBundle\Entity\Predesign $design)
    {
        $this->predesign = $design;

        return $this;
    }

    public function getPredesign()
    {
        return $this->predesign;
    }

    public function setPredesign(\Rha\ProjectManagementBundle\Entity\Predesign $design)
    {
        return $this->addPredesign($desgin);
    }

    public function removePredesign(\Rha\ProjectManagementBundle\Entity\Predesign $design)
    {
        $this->predesign->removeElement($design);
    }

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="Production")
     */
    protected $production;

    public function addProduction(\Rha\ProjectManagementBundle\Entity\Production $value)
    {
        $this->production = $value;

        return $this;
    }

    public function getProduction()
    {
        return $this->production;
    }

    public function setProduction(\Rha\ProjectManagementBundle\Entity\Production $value)
    {
        return $this->addProduction($value);
    }

    public function removeProduction(\Rha\ProjectManagementBundle\Entity\Production $value)
    {
        $this->production->removeElement($value);
    }

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="Permit")
     */
    protected $permit;

    public function addPermit(\Rha\ProjectManagementBundle\Entity\Permit $value)
    {
        $this->permit = $value;

        return $this;
    }

    public function getPermit()
    {
        return $this->permit;
    }

    public function setPermit(\Rha\ProjectManagementBundle\Entity\Permit $value)
    {
        return $this->addPermit($value);
    }

    public function removePermit(\Rha\ProjectManagementBundle\Entity\Permit $value)
    {
        $this->permit->removeElement($value);
    }

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="ConstructionAdministration")
     */
    protected $constructionAdministration;

    public function addConstructionAdministration(\Rha\ProjectManagementBundle\Entity\ConstructionAdministration $value)
    {
        $this->constructionAdministration = $value;

        return $this;
    }

    public function getConstructionAdministration()
    {
        return $this->constructionAdministration;
    }

    public function setConstructionAdministration(\Rha\ProjectManagementBundle\Entity\ConstructionAdministration $value)
    {
        return $this->addConstructionAdministration($value);
    }

    public function removeConstructionAdministration(\Rha\ProjectManagementBundle\Entity\ConstructionAdministration $value)
    {
        $this->constructionAdministration->removeElement($value);
    }

    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="Calculation")
     */
    protected $calculation;

    public function addCalculation(\Rha\ProjectManagementBundle\Entity\Calculation $value)
    {
        $this->calculation = $value;

        return $this;
    }

    public function getCalculation()
    {
        return $this->calculation;
    }

    public function setCalculation(\Rha\ProjectManagementBundle\Entity\Calculation $value)
    {
        return $this->addCalculation($value);
    }

    public function removeCalculation(\Rha\ProjectManagementBundle\Entity\Calculation $value)
    {
        $this->calculation->removeElement($value);
    }
}
