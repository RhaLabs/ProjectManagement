<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Dates
 * @ORM\Entity
 * @ORM\Table(name="trident", indexes=
 {
 @ORM\Index(name="idx", columns={"runDate"}),
 @ORM\Index(name="pwo_idx", columns={"pwoPrj"}),
 @ORM\Index(name="pwo_a_idx", columns={"pwoAct"}),
 @ORM\Index(name="otp_idx", columns={"otpPrj"}),
 @ORM\Index(name="otp_a_idx", columns={"otpAct"}),
 @ORM\Index(name="otb_idx", columns={"otbPrj"}),
 @ORM\Index(name="otb_a_idx", columns={"otbAct"}),
 @ORM\Index(name="poss_idx", columns={"possPrj"}),
 @ORM\Index(name="poss_a_idx", columns={"possAct"}),
 @ORM\Index(name="go_idx", columns={"goPrj"}),
 @ORM\Index(name="go_idx", columns={"goAct"})
 }
 )
 */
class Dates extends \Application\GlobalBundle\Entity\BaseDates
{
    /**
     * @var string
     * @ORM\Column(type="datetime")
     */
    private $runDate;

    public function __construct()
    {
        $this->projects = new ArrayCollection();
    }

    public function setRundate($rundate)
    {
        $this->runDate = $rundate;

        return $this;
    }

    public function getRundate()
    {
        return $this->runDate;
    }

    public function setDateChanged($property, $value)
    {
        $property = $this->TransformProperty($property);

        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }

    public function getDateChanged($property)
    {
        $property = $this->TransformProperty($property);

        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return false;
    }

    private function TransformProperty($property)
    {
        return $property.'Changed';
    }

    public function __get($method)
    {
        switch (true) {
            case (0 == strpos($method, 'get')):
                $property = substr($method, 3);
                break;
            default:
                $property = $method;
        }

        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return;
    }

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $retPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $retActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $phaseIActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $PhaseIIActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archRecPkgPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archRecPkgActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $recPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $recActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $leaseExecutePrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $leaseExecuteActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $landUcPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $landUcActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $drcDrbPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $drcDrbActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pAndZPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pAndZActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cityCouncilPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cityCouncilActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $entitlePrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $entitleActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $desCivilPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $desCivilActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cwaPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $cwaActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pwoIdPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pwoIdActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $intClosingPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $intClosingActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pwoPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $pwoActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $otpPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $otpActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archPermitPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $archPermitActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $civilPermitPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $civilPermitActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $otbReviewPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $otbReviewActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $otbPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $otbActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bidDatePrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bidDateActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $awardPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $awardActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $constrStartPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $constrStartActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $possPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $possActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $goPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $goActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bldgPermitActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $bldgPermitPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $closingActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $closingPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $preBidMtgChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $devConstComplActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $devConstComplPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $devConstStartActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $devConstStartPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $devPadActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $devPadPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $finalCivilsActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $finalCivilsPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rentCommenceActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rentCommencePrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rezoneAppealActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $rezoneAppealPrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $siteRezoneActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $siteRezonePrjChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $warrantyComplActChanged;

    /**
     * @var string
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $warrantyComplPrjChanged;
}
