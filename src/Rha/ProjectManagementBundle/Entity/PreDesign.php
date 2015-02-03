<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\PreDesignRepository")
 * @ORM\Table(name="predesign", indexes=
        {
          @ORM\Index(name="date_idx", columns={"createDate"})
        }
      )
 */
class PreDesign extends \Application\GlobalBundle\Entity\BaseEntity
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $dueDiligence;

    public function getDueDiligence()
    {
        return $this->dueDiligence;
    }

    public function setDueDiligence($value)
    {
        $this->dueDiligence = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $becr;

    public function getBecr()
    {
        return $this->becr;
    }

    public function setBecr($value)
    {
        $this->becr = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $rendering;

    public function getRendering()
    {
        return $this->rendering;
    }

    public function setRendering($value)
    {
        $this->rendering = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $renderingQuantity;

    public function getRenderingQuantity()
    {
        return $this->renderingQuantity;
    }

    public function setRenderingQuantity($value)
    {
        $this->renderingQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $samplesBoard;

    public function getSamplesBoard()
    {
        return $this->samplesBoard;
    }

    public function setSamplesBoard($value)
    {
        $this->samplesBoard = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $samplesBoardQuantity;

    public function getSamplesBoardQuantity()
    {
        return $this->samplesBoardQuantity;
    }

    public function setSamplesBoardQuantity($value)
    {
        $this->samplesBoardQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $cityStaffMeeting;

    public function getCityStaffMeeting()
    {
        return $this->cityStaffMeeting;
    }

    public function setCityStaffMeeting($value)
    {
        $this->cityStaffMeeting = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $cityStaffMeetingQuantity;

    public function getCityStaffMeetingQuantity()
    {
        return $this->cityStaffMeetingQuantity;
    }

    public function setCityStaffMeetingQuantity($value)
    {
        $this->cityStaffMeetingQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $cityPlanningMeeting;

    public function getCityPlanningMeeting()
    {
        return $this->cityPlanningMeeting;
    }

    public function setCityPlanningMeeting($value)
    {
        $this->cityPlanningMeeting = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $cityPlanningMeetingQuantity;

    public function getCityPlanningMeetingQuantity()
    {
        return $this->cityPlanningMeetingQuantity;
    }

    public function setCityPlanningMeetingQuantity($value)
    {
        $this->cityPlanningMeetingQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $cityCouncilMeeting;

    public function getCityCouncilMeeting()
    {
        return $this->cityCouncilMeeting;
    }

    public function setCityCouncilMeeting($value)
    {
        $this->cityCouncilMeeting = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $cityCouncilMeetingQuantity;

    public function getCityCouncilMeetingQuantity()
    {
        return $this->cityCouncilMeetingQuantity;
    }

    public function setCityCouncilMeetingQuantity($value)
    {
        $this->cityCouncilMeetingQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $communityMeeting;

    public function getCommunityMeeting()
    {
        return $this->communityMeeting;
    }

    public function setCommunityMeeting($value)
    {
        $this->communityMeeting = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $communityMeetingQuantity;

    public function getCommunityMeetingQuantity()
    {
        return $this->communityMeetingQuantity;
    }

    public function setCommunityMeetingQuantity($value)
    {
        $this->communityMeetingQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $civilWalkAround;

    public function getCivilWalkAround()
    {
        return $this->civilWalkAround;
    }

    public function setCivilWalkAround($value)
    {
        $this->civilWalkAround = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $civilWalkAroundQuantity;

    public function getCivilWalkAroundQuantity()
    {
        return $this->civilWalkAroundQuantity;
    }

    public function setCivilWalkAroundQuantity($value)
    {
        $this->civilWalkAroundQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $designPackage;

    public function getDesignPackage()
    {
        return $this->designPackage;
    }

    public function setDesignPackage($value)
    {
        $this->designPackage = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $designPackageQuantity;

    public function getDesignPackageQuantity()
    {
        return $this->designPackageQuantity;
    }

    public function setDesignPackageQuantity($value)
    {
        $this->designPackageQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $administration;

    public function getAdministration()
    {
        return $this->administration;
    }

    public function setAdministration($value)
    {
        $this->administration = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $administrationQuantity;

    public function getAdministrationQuantity()
    {
        return $this->administrationQuantity;
    }

    public function setAdministrationQuantity($value)
    {
        $this->administrationQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $travel;

    public function getTravel()
    {
        return $this->travel;
    }

    public function setTravel($value)
    {
        $this->travel = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $travelQuantity;

    public function getTravelQuantity()
    {
        return $this->travelQuantity;
    }

    public function setTravelQuantity($value)
    {
        $this->travelQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $expenses;

    public function getExpenses()
    {
        return $this->expenses;
    }

    public function setExpenses($value)
    {
        $this->expenses = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $expensesQuantity;

    public function getExpensesQuantity()
    {
        return $this->expensesQuantity;
    }

    public function setExpensesQuantity($value)
    {
        $this->expensesQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $hotel;

    public function getHotel()
    {
        return $this->hotel;
    }

    public function setHotel($value)
    {
        $this->hotel = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $hotelQuantity;

    public function getHotelQuantity()
    {
        return $this->hotelQuantity;
    }

    public function setHotelQuantity($value)
    {
        $this->hotelQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $flight;

    public function getFlight()
    {
        return $this->flight;
    }

    public function setFlight($value)
    {
        $this->flight = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $flightQuantity;

    public function getFlightQuantity()
    {
        return $this->flightQuantity;
    }

    public function setFlightQuantity($value)
    {
        $this->flightQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $vehicle;

    public function getVehicle()
    {
        return $this->vehicle;
    }

    public function setVehicle($value)
    {
        $this->vehicle = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $vehicleQuantity;

    public function getVehicleQuantity()
    {
        return $this->vehicleQuantity;
    }

    public function setVehicleQuantity($value)
    {
        $this->vehicleQuantity = $value;

        return $this;
    }
}
