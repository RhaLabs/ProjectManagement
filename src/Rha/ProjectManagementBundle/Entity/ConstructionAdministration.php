<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\ConstructionAdministrationRepository")
 * @ORM\Table(name="construction_admin", indexes=
        {
          @ORM\Index(name="geo_idx", columns={"createDate"})
        }
      )
 */
class ConstructionAdministration extends \Application\GlobalBundle\Entity\BaseEntity
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $buildingConstructionAdministration;

    public function getBuidlingConstructionAdministration()
    {
        return $this->buildingConstructionAdministration;
    }

    public function setBuildingConstructionAdministration($value)
    {
        $this->buildingConstructionAdministration = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $fuelStationConstructionAdministration;

    public function getFuelStationConstructionAdministration()
    {
        return $this->fuelStationConstructionAdministration;
    }

    public function setFuelStationConstructionAdministration($value)
    {
        $this->fuelStationConstructionAdministration = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $bidQuestion;

    public function getBidQuestion()
    {
        return $this->bidQuestion;
    }

    public function setBidQuestion($value)
    {
        $this->bidQuestion = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $rfiResponse;

    public function getRfiResponse()
    {
        return $this->rfiResponse;
    }

    public function setRfiResponse($value)
    {
        $this->rfiResponse = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $submittalReview;

    public function getSubmittalReview()
    {
        return $this->submittalReview;
    }

    public function setSubmittalReview($value)
    {
        $this->submittalReview = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $precastSubmittalReview;

    public function getPrecastSubmittalReview()
    {
        return $this->precastSubmittalReview;
    }

    public function setPrecastSubmittalReview($value)
    {
        $this->precastSubmittalReview = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $fuelStationSubmittalReview;

    public function getFuelStationSubmittalReview()
    {
        return $this->fuelStationSubmittalReview;
    }

    public function setFuelStationSubmittalReview($value)
    {
        $this->fuelStationSubmittalReview = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $highWindSubmittalReview;

    public function getHighWindSubmittalReview()
    {
        return $this->highWindSubmittalReview;
    }

    public function setHighWindSubmittalReview($value)
    {
        $this->highWindSubmittalReview = $value;

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
    protected $fuelStationFuelStationAdministration;

    public function getFuelStationAdministration()
    {
        return $this->fuelStationFuelStationAdministration;
    }

    public function setFuelStationAdministration($value)
    {
        $this->fuelStationFuelStationAdministration = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $distributedTime;

    public function getDistributedTime()
    {
        return $this->distributedTime;
    }

    public function setDistributedTime($value)
    {
        $this->distributedTime = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $biuldingBuildingObservation;

    public function getBuildingObservation()
    {
        return $this->buildingBiuldingObservation;
    }

    public function setBuildingObservation($value)
    {
        $this->biuldingBuildingObservation = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $fuelStationObservation;

    public function getFuelStationObservation()
    {
        return $this->fuelStationObservation;
    }

    public function setFuelStationObservation($value)
    {
        $this->fuelStationObservation = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $documentClarification;

    public function getDocumentClarification()
    {
        return $this->documentClarification;
    }

    public function setDocumentClarification($value)
    {
        $this->documentClarification = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $observationTravelTimeTime;

    public function getObservationTravelTime()
    {
        return $this->observationTravelTimeTime;
    }

    public function setObservationTravelTime($value)
    {
        $this->observationTravelTimeTime = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $observationTravelQuantity;

    public function getObservationTravelQuantity()
    {
        return $this->observationTravelQuantity;
    }

    public function setObservationTravelQuantity($value)
    {
        $this->observationTravelQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $observationExpenses;

    public function getObservationExpenses()
    {
        return $this->observationExpenses;
    }

    public function setObservationExpenses($value)
    {
        $this->observationExpenses = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $observationExpensesQuantity;

    public function getObservationExpensesQuantity()
    {
        return $this->observationExpensesQuantity;
    }

    public function setObservationExpensesQuantity($value)
    {
        $this->observationExpensesQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $observationHotel;

    public function getObservationHotel()
    {
        return $this->observationHotel;
    }

    public function setObservationHotel($value)
    {
        $this->observationHotel = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $observationHotelQuantity;

    public function getObservationHotelQuantity()
    {
        return $this->observationHotelQuantity;
    }

    public function setObservationHotelQuantity($value)
    {
        $this->observationHotelQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $observationFlight;

    public function getObservationFlight()
    {
        return $this->observationFlight;
    }

    public function setObservationFlight($value)
    {
        $this->observationFlight = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $observationFlightQuantity;

    public function getObservationFlightQuantity()
    {
        return $this->observationFlightQuantity;
    }

    public function setObservationFlightQuantity($value)
    {
        $this->observationFlightQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $observationVehicle;

    public function getObservationVehicle()
    {
        return $this->observationVehicle;
    }

    public function setObservationVehicle($value)
    {
        $this->observationVehicle = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $observationVehicleQuantity;

    public function getObservationVehicleQuantity()
    {
        return $this->observationVehicleQuantity;
    }

    public function setObservationVehicleQuantity($value)
    {
        $this->observationVehicleQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preBidTravelTimeTime;

    public function getPreBidTravelTime()
    {
        return $this->preBidTravelTimeTime;
    }

    public function setPreBidTravelTime($value)
    {
        $this->preBidTravelTimeTime = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preBidTravelQuantity;

    public function getPreBidTravelQuantity()
    {
        return $this->preBidTravelQuantity;
    }

    public function setPreBidTravelQuantity($value)
    {
        $this->preBidTravelQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preBidExpenses;

    public function getPreBidExpenses()
    {
        return $this->preBidExpenses;
    }

    public function setPreBidExpenses($value)
    {
        $this->preBidExpenses = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preBidExpensesQuantity;

    public function getPreBidExpensesQuantity()
    {
        return $this->preBidExpensesQuantity;
    }

    public function setPreBidExpensesQuantity($value)
    {
        $this->preBidExpensesQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preBidHotel;

    public function getPreBidHotel()
    {
        return $this->preBidHotel;
    }

    public function setPreBidHotel($value)
    {
        $this->preBidHotel = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preBidHotelQuantity;

    public function getPreBidHotelQuantity()
    {
        return $this->preBidHotelQuantity;
    }

    public function setPreBidHotelQuantity($value)
    {
        $this->preBidHotelQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preBidFlight;

    public function getPreBidFlight()
    {
        return $this->preBidFlight;
    }

    public function setPreBidFlight($value)
    {
        $this->preBidFlight = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preBidFlightQuantity;

    public function getPreBidFlightQuantity()
    {
        return $this->preBidFlightQuantity;
    }

    public function setPreBidFlightQuantity($value)
    {
        $this->preBidFlightQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preBidVehicle;

    public function getPreBidVehicle()
    {
        return $this->preBidVehicle;
    }

    public function setPreBidVehicle($value)
    {
        $this->preBidVehicle = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preBidVehicleQuantity;

    public function getPreBidVehicleQuantity()
    {
        return $this->preBidVehicleQuantity;
    }

    public function setPreBidVehicleQuantity($value)
    {
        $this->preBidVehicleQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preConstructionTravelTimeTime;

    public function getPreConstructionTravelTime()
    {
        return $this->preConstructionTravelTimeTime;
    }

    public function setPreConstructionTravelTime($value)
    {
        $this->preConstructionTravelTimeTime = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preConstructionTravelQuantity;

    public function getPreConstructionTravelQuantity()
    {
        return $this->preConstructionTravelQuantity;
    }

    public function setPreConstructionTravelQuantity($value)
    {
        $this->preConstructionTravelQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preConstructionExpenses;

    public function getPreConstructionExpenses()
    {
        return $this->preConstructionExpenses;
    }

    public function setPreConstructionExpenses($value)
    {
        $this->preConstructionExpenses = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preConstructionExpensesQuantity;

    public function getPreConstructionExpensesQuantity()
    {
        return $this->preConstructionExpensesQuantity;
    }

    public function setPreConstructionExpensesQuantity($value)
    {
        $this->preConstructionExpensesQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preConstructionHotel;

    public function getPreConstructionHotel()
    {
        return $this->preConstructionHotel;
    }

    public function setPreConstructionHotel($value)
    {
        $this->preConstructionHotel = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preConstructionHotelQuantity;

    public function getPreConstructionHotelQuantity()
    {
        return $this->preConstructionHotelQuantity;
    }

    public function setPreConstructionHotelQuantity($value)
    {
        $this->preConstructionHotelQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preConstructionFlight;

    public function getPreConstructionFlight()
    {
        return $this->preConstructionFlight;
    }

    public function setPreConstructionFlight($value)
    {
        $this->preConstructionFlight = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preConstructionFlightQuantity;

    public function getPreConstructionFlightQuantity()
    {
        return $this->preConstructionFlightQuantity;
    }

    public function setPreConstructionFlightQuantity($value)
    {
        $this->preConstructionFlightQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preConstructionVehicle;

    public function getPreConstructionVehicle()
    {
        return $this->preConstructionVehicle;
    }

    public function setPreConstructionVehicle($value)
    {
        $this->preConstructionVehicle = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $preConstructionVehicleQuantity;

    public function getPreConstructionVehicleQuantity()
    {
        return $this->preConstructionVehicleQuantity;
    }

    public function setPreConstructionVehicleQuantity($value)
    {
        $this->preConstructionVehicleQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $additionalTravelTimeTime;

    public function getAdditionalTravelTime()
    {
        return $this->additionalTravelTimeTime;
    }

    public function setAdditionalTravelTime($value)
    {
        $this->additionalTravelTimeTime = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $additionalTravelQuantity;

    public function getAdditionalTravelQuantity()
    {
        return $this->additionalTravelQuantity;
    }

    public function setAdditionalTravelQuantity($value)
    {
        $this->additionalTravelQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $additionalExpenses;

    public function getAdditionalExpenses()
    {
        return $this->additionalExpenses;
    }

    public function setAdditionalExpenses($value)
    {
        $this->additionalExpenses = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $additionalExpensesQuantity;

    public function getAdditionalExpensesQuantity()
    {
        return $this->additionalExpensesQuantity;
    }

    public function setAdditionalExpensesQuantity($value)
    {
        $this->additionalExpensesQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $additionalHotel;

    public function getAdditionalHotel()
    {
        return $this->additionalHotel;
    }

    public function setAdditionalHotel($value)
    {
        $this->additionalHotel = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $additionalHotelQuantity;

    public function getAdditionalHotelQuantity()
    {
        return $this->additionalHotelQuantity;
    }

    public function setAdditionalHotelQuantity($value)
    {
        $this->additionalHotelQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $additionalFlight;

    public function getAdditionalFlight()
    {
        return $this->additionalFlight;
    }

    public function setAdditionalFlight($value)
    {
        $this->additionalFlight = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $additionalFlightQuantity;

    public function getAdditionalFlightQuantity()
    {
        return $this->additionalFlightQuantity;
    }

    public function setAdditionalFlightQuantity($value)
    {
        $this->additionalFlightQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $additionalVehicle;

    public function getAdditionalVehicle()
    {
        return $this->additionalVehicle;
    }

    public function setAdditionalVehicle($value)
    {
        $this->additionalVehicle = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $additionalVehicleQuantity;

    public function getAdditionalVehicleQuantity()
    {
        return $this->additionalVehicleQuantity;
    }

    public function setAdditionalVehicleQuantity($value)
    {
        $this->additionalVehicleQuantity = $value;

        return $this;
    }
}
