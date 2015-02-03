<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\PermitRepository")
 * @ORM\Table(name="permit", indexes=
        {
          @ORM\Index(name="date_idx", columns={"createDate"})
        }
      )
 */
class Permit extends \Application\GlobalBundle\Entity\BaseEntity
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $comments;

    public function getComments()
    {
        return $this->comments;
    }

    public function setComments($value)
    {
        $this->comments = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $commentsQuantity;

    public function getCommentsQuantity()
    {
        return $this->commentsQuantity;
    }

    public function setCommentsQuantity($value)
    {
        $this->commentsQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $extraComments;

    public function getExtraComments()
    {
        return $this->extraComments;
    }

    public function setExtraComments($value)
    {
        $this->extraComments = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $extraCommentsQuantity;

    public function getExtraCommentsQuantity()
    {
        return $this->extraCommentsQuantity;
    }

    public function setExtraCommentsQuantity($value)
    {
        $this->extraCommentsQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $handSubmission;

    public function getHandSubmission()
    {
        return $this->handSubmission;
    }

    public function setHandSubmission($value)
    {
        $this->handSubmission = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $handSubmissionQuantity;

    public function getHandSubmissionQuantity()
    {
        return $this->handSubmissionQuantity;
    }

    public function setHandSubmissionQuantity($value)
    {
        $this->handSubmissionQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $fuelStation;

    public function getFuelStation()
    {
        return $this->fuelStation;
    }

    public function setFuelStation($value)
    {
        $this->fuelStation = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $fuelStationQuantity;

    public function getFuelStationQuantity()
    {
        return $this->fuelStationQuantity;
    }

    public function setFuelStationQuantity($value)
    {
        $this->fuelStationQuantity = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $peerReviewResponse;

    public function getPeerReviewResponse()
    {
        return $this->peerReviewResponse;
    }

    public function setPeerReviewResponse($value)
    {
        $this->peerReviewResponse = $value;

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
