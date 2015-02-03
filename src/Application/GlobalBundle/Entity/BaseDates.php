<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Trident
 * @ORM\MappedSuperclass
 */
class BaseDates
{
    public function set($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }
    public function get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $retPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $retAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $phaseIAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $PhaseIIAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $archRecPkgPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $archRecPkgAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $recPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $recAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $leaseExecutePrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $leaseExecuteAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $landUcPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $landUcAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $drcDrbPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $drcDrbAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $pAndZPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $pAndZAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $cityCouncilPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $cityCouncilAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $entitlePrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $entitleAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $desCivilPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $desCivilAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $cwaPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $cwaAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $pwoIdPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $pwoIdAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $intClosingPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $intClosingAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $pwoPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $pwoAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $otpPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $otpAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $archPermitPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $archPermitAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $civilPermitPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $civilPermitAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $otbReviewPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $otbReviewAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $otbPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $otbAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $bidDatePrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $bidDateAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $awardPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $awardAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $constrStartPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $constrStartAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $possPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $possAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $goPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $goAct;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $otbPossDays;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $bldgPermitAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $bldgPermitPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $closingAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $closingPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $preBidMtg;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $devConstComplAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $devConstComplPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $devConstStartAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $devConstStartPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $devPadAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $devPadPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $finalCivilsAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $finalCivilsPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $rentCommenceAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $rentCommencePrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $rezoneAppealAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $rezoneAppealPrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $siteRezoneAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $siteRezonePrj;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $warrantyComplAct;

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $warrantyComplPrj;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
    }

    /**
     * Set retPrj
     *
     * @param  \DateTime $retPrj
     * @return Trident
     */
    public function setRetPrj($retPrj)
    {
        $this->retPrj = $retPrj;

        return $this;
    }

    /**
     * Get retPrj
     *
     * @return \DateTime
     */
    public function getRetPrj()
    {
        return $this->retPrj;
    }

    /**
     * Set retAct
     *
     * @param  \DateTime $retAct
     * @return Trident
     */
    public function setRetAct($retAct)
    {
        $this->retAct = $retAct;

        return $this;
    }

    /**
     * Get retAct
     *
     * @return \DateTime
     */
    public function getRetAct()
    {
        return $this->retAct;
    }

    /**
     * Set phaseIAct
     *
     * @param  \DateTime $phaseIAct
     * @return Trident
     */
    public function setPhaseIAct($phaseIAct)
    {
        $this->phaseIAct = $phaseIAct;

        return $this;
    }

    /**
     * Get phaseIAct
     *
     * @return \DateTime
     */
    public function getPhaseIAct()
    {
        return $this->phaseIAct;
    }

    /**
     * Set PhaseIIAct
     *
     * @param  \DateTime $phaseIIAct
     * @return Trident
     */
    public function setPhaseIIAct($phaseIIAct)
    {
        $this->PhaseIIAct = $phaseIIAct;

        return $this;
    }

    /**
     * Get PhaseIIAct
     *
     * @return \DateTime
     */
    public function getPhaseIIAct()
    {
        return $this->PhaseIIAct;
    }

    /**
     * Set archRecPkgPrj
     *
     * @param  \DateTime $archRecPkgPrj
     * @return Trident
     */
    public function setArchRecPkgPrj($archRecPkgPrj)
    {
        $this->archRecPkgPrj = $archRecPkgPrj;

        return $this;
    }

    /**
     * Get archRecPkgPrj
     *
     * @return \DateTime
     */
    public function getArchRecPkgPrj()
    {
        return $this->archRecPkgPrj;
    }

    /**
     * Set archRecPkgAct
     *
     * @param  \DateTime $archRecPkgAct
     * @return Trident
     */
    public function setArchRecPkgAct($archRecPkgAct)
    {
        $this->archRecPkgAct = $archRecPkgAct;

        return $this;
    }

    /**
     * Get archRecPkgAct
     *
     * @return \DateTime
     */
    public function getArchRecPkgAct()
    {
        return $this->archRecPkgAct;
    }

    /**
     * Set recPrj
     *
     * @param  \DateTime $recPrj
     * @return Trident
     */
    public function setRecPrj($recPrj)
    {
        $this->recPrj = $recPrj;

        return $this;
    }

    /**
     * Get recPrj
     *
     * @return \DateTime
     */
    public function getRecPrj()
    {
        return $this->recPrj;
    }

    /**
     * Set recAct
     *
     * @param  \DateTime $recAct
     * @return Trident
     */
    public function setRecAct($recAct)
    {
        $this->recAct = $recAct;

        return $this;
    }

    /**
     * Get recAct
     *
     * @return \DateTime
     */
    public function getRecAct()
    {
        return $this->recAct;
    }

    /**
     * Set leaseExecutePrj
     *
     * @param  \DateTime $leaseExecutePrj
     * @return Trident
     */
    public function setLeaseExecutePrj($leaseExecutePrj)
    {
        $this->leaseExecutePrj = $leaseExecutePrj;

        return $this;
    }

    /**
     * Get leaseExecutePrj
     *
     * @return \DateTime
     */
    public function getLeaseExecutePrj()
    {
        return $this->leaseExecutePrj;
    }

    /**
     * Set leaseExecuteAct
     *
     * @param  \DateTime $leaseExecuteAct
     * @return Trident
     */
    public function setLeaseExecuteAct($leaseExecuteAct)
    {
        $this->leaseExecuteAct = $leaseExecuteAct;

        return $this;
    }

    /**
     * Get leaseExecuteAct
     *
     * @return \DateTime
     */
    public function getLeaseExecuteAct()
    {
        return $this->leaseExecuteAct;
    }

    /**
     * Set landUcPrj
     *
     * @param  \DateTime $landUcPrj
     * @return Trident
     */
    public function setLandUcPrj($landUcPrj)
    {
        $this->landUcPrj = $landUcPrj;

        return $this;
    }

    /**
     * Get landUcPrj
     *
     * @return \DateTime
     */
    public function getLandUcPrj()
    {
        return $this->landUcPrj;
    }

    /**
     * Set landUcAct
     *
     * @param  \DateTime $landUcAct
     * @return Trident
     */
    public function setLandUcAct($landUcAct)
    {
        $this->landUcAct = $landUcAct;

        return $this;
    }

    /**
     * Get landUcAct
     *
     * @return \DateTime
     */
    public function getLandUcAct()
    {
        return $this->landUcAct;
    }

    /**
     * Set drcDrbPrj
     *
     * @param  \DateTime $drcDrbPrj
     * @return Trident
     */
    public function setDrcDrbPrj($drcDrbPrj)
    {
        $this->drcDrbPrj = $drcDrbPrj;

        return $this;
    }

    /**
     * Get drcDrbPrj
     *
     * @return \DateTime
     */
    public function getDrcDrbPrj()
    {
        return $this->drcDrbPrj;
    }

    /**
     * Set drcDrbAct
     *
     * @param  \DateTime $drcDrbAct
     * @return Trident
     */
    public function setDrcDrbAct($drcDrbAct)
    {
        $this->drcDrbAct = $drcDrbAct;

        return $this;
    }

    /**
     * Get drcDrbAct
     *
     * @return \DateTime
     */
    public function getDrcDrbAct()
    {
        return $this->drcDrbAct;
    }

    /**
     * Set pAndZPrj
     *
     * @param  \DateTime $pAndZPrj
     * @return Trident
     */
    public function setPAndZPrj($pAndZPrj)
    {
        $this->pAndZPrj = $pAndZPrj;

        return $this;
    }

    /**
     * Get pAndZPrj
     *
     * @return \DateTime
     */
    public function getPAndZPrj()
    {
        return $this->pAndZPrj;
    }

    /**
     * Set pAndZAct
     *
     * @param  \DateTime $pAndZAct
     * @return Trident
     */
    public function setPAndZAct($pAndZAct)
    {
        $this->pAndZAct = $pAndZAct;

        return $this;
    }

    /**
     * Get pAndZAct
     *
     * @return \DateTime
     */
    public function getPAndZAct()
    {
        return $this->pAndZAct;
    }

    /**
     * Set cityCouncilPrj
     *
     * @param  \DateTime $cityCouncilPrj
     * @return Trident
     */
    public function setCityCouncilPrj($cityCouncilPrj)
    {
        $this->cityCouncilPrj = $cityCouncilPrj;

        return $this;
    }

    /**
     * Get cityCouncilPrj
     *
     * @return \DateTime
     */
    public function getCityCouncilPrj()
    {
        return $this->cityCouncilPrj;
    }

    /**
     * Set cityCouncilAct
     *
     * @param  \DateTime $cityCouncilAct
     * @return Trident
     */
    public function setCityCouncilAct($cityCouncilAct)
    {
        $this->cityCouncilAct = $cityCouncilAct;

        return $this;
    }

    /**
     * Get cityCouncilAct
     *
     * @return \DateTime
     */
    public function getCityCouncilAct()
    {
        return $this->cityCouncilAct;
    }

    /**
     * Set entitlePrj
     *
     * @param  \DateTime $entitlePrj
     * @return Trident
     */
    public function setEntitlePrj($entitlePrj)
    {
        $this->entitlePrj = $entitlePrj;

        return $this;
    }

    /**
     * Get entitlePrj
     *
     * @return \DateTime
     */
    public function getEntitlePrj()
    {
        return $this->entitlePrj;
    }

    /**
     * Set entitleAct
     *
     * @param  \DateTime $entitleAct
     * @return Trident
     */
    public function setEntitleAct($entitleAct)
    {
        $this->entitleAct = $entitleAct;

        return $this;
    }

    /**
     * Get entitleAct
     *
     * @return \DateTime
     */
    public function getEntitleAct()
    {
        return $this->entitleAct;
    }

    /**
     * Set desCivilPrj
     *
     * @param  \DateTime $desCivilPrj
     * @return Trident
     */
    public function setDesCivilPrj($desCivilPrj)
    {
        $this->desCivilPrj = $desCivilPrj;

        return $this;
    }

    /**
     * Get desCivilPrj
     *
     * @return \DateTime
     */
    public function getDesCivilPrj()
    {
        return $this->desCivilPrj;
    }

    /**
     * Set desCivilAct
     *
     * @param  \DateTime $desCivilAct
     * @return Trident
     */
    public function setDesCivilAct($desCivilAct)
    {
        $this->desCivilAct = $desCivilAct;

        return $this;
    }

    /**
     * Get desCivilAct
     *
     * @return \DateTime
     */
    public function getDesCivilAct()
    {
        return $this->desCivilAct;
    }

    /**
     * Set cwaPrj
     *
     * @param  \DateTime $cwaPrj
     * @return Trident
     */
    public function setCwaPrj($cwaPrj)
    {
        $this->cwaPrj = $cwaPrj;

        return $this;
    }

    /**
     * Get cwaPrj
     *
     * @return \DateTime
     */
    public function getCwaPrj()
    {
        return $this->cwaPrj;
    }

    /**
     * Set cwaAct
     *
     * @param  \DateTime $cwaAct
     * @return Trident
     */
    public function setCwaAct($cwaAct)
    {
        $this->cwaAct = $cwaAct;

        return $this;
    }

    /**
     * Get cwaAct
     *
     * @return \DateTime
     */
    public function getCwaAct()
    {
        return $this->cwaAct;
    }

    /**
     * Set pwoIdPrj
     *
     * @param  \DateTime $pwoIdPrj
     * @return Trident
     */
    public function setPwoIdPrj($pwoIdPrj)
    {
        $this->pwoIdPrj = $pwoIdPrj;

        return $this;
    }

    /**
     * Get pwoIdPrj
     *
     * @return \DateTime
     */
    public function getPwoIdPrj()
    {
        return $this->pwoIdPrj;
    }

    /**
     * Set pwoIdAct
     *
     * @param  \DateTime $pwoIdAct
     * @return Trident
     */
    public function setPwoIdAct($pwoIdAct)
    {
        $this->pwoIdAct = $pwoIdAct;

        return $this;
    }

    /**
     * Get pwoIdAct
     *
     * @return \DateTime
     */
    public function getPwoIdAct()
    {
        return $this->pwoIdAct;
    }

    /**
     * Set intClosingPrj
     *
     * @param  \DateTime $intClosingPrj
     * @return Trident
     */
    public function setIntClosingPrj($intClosingPrj)
    {
        $this->intClosingPrj = $intClosingPrj;

        return $this;
    }

    /**
     * Get intClosingPrj
     *
     * @return \DateTime
     */
    public function getIntClosingPrj()
    {
        return $this->intClosingPrj;
    }

    /**
     * Set intClosingAct
     *
     * @param  \DateTime $intClosingAct
     * @return Trident
     */
    public function setIntClosingAct($intClosingAct)
    {
        $this->intClosingAct = $intClosingAct;

        return $this;
    }

    /**
     * Get intClosingAct
     *
     * @return \DateTime
     */
    public function getIntClosingAct()
    {
        return $this->intClosingAct;
    }

    /**
     * Set pwoPrj
     *
     * @param  \DateTime $pwoPrj
     * @return Trident
     */
    public function setPwoPrj($pwoPrj)
    {
        $this->pwoPrj = $pwoPrj;

        return $this;
    }

    /**
     * Get pwoPrj
     *
     * @return \DateTime
     */
    public function getPwoPrj()
    {
        return $this->pwoPrj;
    }

    /**
     * Set pwoAct
     *
     * @param  \DateTime $pwoAct
     * @return Trident
     */
    public function setPwoAct($pwoAct)
    {
        $this->pwoAct = $pwoAct;

        return $this;
    }

    /**
     * Get pwoAct
     *
     * @return \DateTime
     */
    public function getPwoAct()
    {
        return $this->pwoAct;
    }

    /**
     * Set otpPrj
     *
     * @param  \DateTime $otpPrj
     * @return Trident
     */
    public function setOtpPrj($otpPrj)
    {
        $this->otpPrj = $otpPrj;

        return $this;
    }

    /**
     * Get otpPrj
     *
     * @return \DateTime
     */
    public function getOtpPrj()
    {
        return $this->otpPrj;
    }

    /**
     * Set otpAct
     *
     * @param  \DateTime $otpAct
     * @return Trident
     */
    public function setOtpAct($otpAct)
    {
        $this->otpAct = $otpAct;

        return $this;
    }

    /**
     * Get otpAct
     *
     * @return \DateTime
     */
    public function getOtpAct()
    {
        return $this->otpAct;
    }

    /**
     * Set archPermitPrj
     *
     * @param  \DateTime $archPermitPrj
     * @return Trident
     */
    public function setArchPermitPrj($archPermitPrj)
    {
        $this->archPermitPrj = $archPermitPrj;

        return $this;
    }

    /**
     * Get archPermitPrj
     *
     * @return \DateTime
     */
    public function getArchPermitPrj()
    {
        return $this->archPermitPrj;
    }

    /**
     * Set archPermitAct
     *
     * @param  \DateTime $archPermitAct
     * @return Trident
     */
    public function setArchPermitAct($archPermitAct)
    {
        $this->archPermitAct = $archPermitAct;

        return $this;
    }

    /**
     * Get archPermitAct
     *
     * @return \DateTime
     */
    public function getArchPermitAct()
    {
        return $this->archPermitAct;
    }

    /**
     * Set civilPermitPrj
     *
     * @param  \DateTime $civilPermitPrj
     * @return Trident
     */
    public function setCivilPermitPrj($civilPermitPrj)
    {
        $this->civilPermitPrj = $civilPermitPrj;

        return $this;
    }

    /**
     * Get civilPermitPrj
     *
     * @return \DateTime
     */
    public function getCivilPermitPrj()
    {
        return $this->civilPermitPrj;
    }

    /**
     * Set civilPermitAct
     *
     * @param  \DateTime $civilPermitAct
     * @return Trident
     */
    public function setCivilPermitAct($civilPermitAct)
    {
        $this->civilPermitAct = $civilPermitAct;

        return $this;
    }

    /**
     * Get civilPermitAct
     *
     * @return \DateTime
     */
    public function getCivilPermitAct()
    {
        return $this->civilPermitAct;
    }

    /**
     * Set otbReviewPrj
     *
     * @param  \DateTime $otbReviewPrj
     * @return Trident
     */
    public function setOtbReviewPrj($otbReviewPrj)
    {
        $this->otbReviewPrj = $otbReviewPrj;

        return $this;
    }

    /**
     * Get otbReviewPrj
     *
     * @return \DateTime
     */
    public function getOtbReviewPrj()
    {
        return $this->otbReviewPrj;
    }

    /**
     * Set otbReviewAct
     *
     * @param  \DateTime $otbReviewAct
     * @return Trident
     */
    public function setOtbReviewAct($otbReviewAct)
    {
        $this->otbReviewAct = $otbReviewAct;

        return $this;
    }

    /**
     * Get otbReviewAct
     *
     * @return \DateTime
     */
    public function getOtbReviewAct()
    {
        return $this->otbReviewAct;
    }

    /**
     * Set otbPrj
     *
     * @param  \DateTime $otbPrj
     * @return Trident
     */
    public function setOtbPrj($otbPrj)
    {
        $this->otbPrj = $otbPrj;

        return $this;
    }

    /**
     * Get otbPrj
     *
     * @return \DateTime
     */
    public function getOtbPrj()
    {
        return $this->otbPrj;
    }

    /**
     * Set otbAct
     *
     * @param  \DateTime $otbAct
     * @return Trident
     */
    public function setOtbAct($otbAct)
    {
        $this->otbAct = $otbAct;

        return $this;
    }

    /**
     * Get otbAct
     *
     * @return \DateTime
     */
    public function getOtbAct()
    {
        return $this->otbAct;
    }

    /**
     * Set bidDatePrj
     *
     * @param  \DateTime $bidDatePrj
     * @return Trident
     */
    public function setBidDatePrj($bidDatePrj)
    {
        $this->bidDatePrj = $bidDatePrj;

        return $this;
    }

    /**
     * Get bidDatePrj
     *
     * @return \DateTime
     */
    public function getBidDatePrj()
    {
        return $this->bidDatePrj;
    }

    /**
     * Set bidDateAct
     *
     * @param  \DateTime $bidDateAct
     * @return Trident
     */
    public function setBidDateAct($bidDateAct)
    {
        $this->bidDateAct = $bidDateAct;

        return $this;
    }

    /**
     * Get bidDateAct
     *
     * @return \DateTime
     */
    public function getBidDateAct()
    {
        return $this->bidDateAct;
    }

    /**
     * Set awardPrj
     *
     * @param  \DateTime $awardPrj
     * @return Trident
     */
    public function setAwardPrj($awardPrj)
    {
        $this->awardPrj = $awardPrj;

        return $this;
    }

    /**
     * Get awardPrj
     *
     * @return \DateTime
     */
    public function getAwardPrj()
    {
        return $this->awardPrj;
    }

    /**
     * Set awardAct
     *
     * @param  \DateTime $awardAct
     * @return Trident
     */
    public function setAwardAct($awardAct)
    {
        $this->awardAct = $awardAct;

        return $this;
    }

    /**
     * Get awardAct
     *
     * @return \DateTime
     */
    public function getAwardAct()
    {
        return $this->awardAct;
    }

    /**
     * Set constrStartPrj
     *
     * @param  \DateTime $constrStartPrj
     * @return Trident
     */
    public function setConstrStartPrj($constrStartPrj)
    {
        $this->constrStartPrj = $constrStartPrj;

        return $this;
    }

    /**
     * Get constrStartPrj
     *
     * @return \DateTime
     */
    public function getConstrStartPrj()
    {
        return $this->constrStartPrj;
    }

    /**
     * Set constrStartAct
     *
     * @param  \DateTime $constrStartAct
     * @return Trident
     */
    public function setConstrStartAct($constrStartAct)
    {
        $this->constrStartAct = $constrStartAct;

        return $this;
    }

    /**
     * Get constrStartAct
     *
     * @return \DateTime
     */
    public function getConstrStartAct()
    {
        return $this->constrStartAct;
    }

    /**
     * Set possPrj
     *
     * @param  \DateTime $possPrj
     * @return Trident
     */
    public function setPossPrj($possPrj)
    {
        $this->possPrj = $possPrj;

        return $this;
    }

    /**
     * Get possPrj
     *
     * @return \DateTime
     */
    public function getPossPrj()
    {
        return $this->possPrj;
    }

    /**
     * Set possAct
     *
     * @param  \DateTime $possAct
     * @return Trident
     */
    public function setPossAct($possAct)
    {
        $this->possAct = $possAct;

        return $this;
    }

    /**
     * Get possAct
     *
     * @return \DateTime
     */
    public function getPossAct()
    {
        return $this->possAct;
    }

    /**
     * Set goPrj
     *
     * @param  \DateTime $goPrj
     * @return Trident
     */
    public function setGoPrj($goPrj)
    {
        $this->goPrj = $goPrj;

        return $this;
    }

    /**
     * Get goPrj
     *
     * @return \DateTime
     */
    public function getGoPrj()
    {
        return $this->goPrj;
    }

    /**
     * Set goAct
     *
     * @param  \DateTime $goAct
     * @return Trident
     */
    public function setGoAct($goAct)
    {
        $this->goAct = $goAct;

        return $this;
    }

    /**
     * Get goAct
     *
     * @return \DateTime
     */
    public function getGoAct()
    {
        return $this->goAct;
    }

    /**
     * Set otbPossDays
     *
     * @param  integer $otbPossDays
     * @return Trident
     */
    public function setOtbPossDays($otbPossDays)
    {
        $this->otbPossDays = $otbPossDays;

        return $this;
    }

    /**
     * Get otbPossDays
     *
     * @return integer
     */
    public function getOtbPossDays()
    {
        return $this->otbPossDays;
    }

    /**
     * Set bldgPermitAct
     *
     * @param  \DateTime $bldgPermitAct
     * @return Trident
     */
    public function setBldgPermitAct($bldgPermitAct)
    {
        $this->bldgPermitAct = $bldgPermitAct;

        return $this;
    }

    /**
     * Get bldgPermitAct
     *
     * @return \DateTime
     */
    public function getBldgPermitAct()
    {
        return $this->bldgPermitAct;
    }

    /**
     * Set bldgPermitPrj
     *
     * @param  \DateTime $bldgPermitPrj
     * @return Trident
     */
    public function setBldgPermitPrj($bldgPermitPrj)
    {
        $this->bldgPermitPrj = $bldgPermitPrj;

        return $this;
    }

    /**
     * Get bldgPermitPrj
     *
     * @return \DateTime
     */
    public function getBldgPermitPrj()
    {
        return $this->bldgPermitPrj;
    }

    /**
     * Set closingAct
     *
     * @param  \DateTime $closingAct
     * @return Trident
     */
    public function setClosingAct($closingAct)
    {
        $this->closingAct = $closingAct;

        return $this;
    }

    /**
     * Get closingAct
     *
     * @return \DateTime
     */
    public function getClosingAct()
    {
        return $this->closingAct;
    }

    /**
     * Set closingPrj
     *
     * @param  \DateTime $closingPrj
     * @return Trident
     */
    public function setClosingPrj($closingPrj)
    {
        $this->closingPrj = $closingPrj;

        return $this;
    }

    /**
     * Get closingPrj
     *
     * @return \DateTime
     */
    public function getClosingPrj()
    {
        return $this->closingPrj;
    }

    /**
     * Set preBidMtg
     *
     * @param  \DateTime $preBidMtg
     * @return Trident
     */
    public function setPreBidMtg($preBidMtg)
    {
        $this->preBidMtg = $preBidMtg;

        return $this;
    }

    /**
     * Get preBidMtg
     *
     * @return \DateTime
     */
    public function getPreBidMtg()
    {
        return $this->preBidMtg;
    }

    /**
     * Set devConstComplAct
     *
     * @param  \DateTime $devConstComplAct
     * @return Trident
     */
    public function setDevConstComplAct($devConstComplAct)
    {
        $this->devConstComplAct = $devConstComplAct;

        return $this;
    }

    /**
     * Get devConstComplAct
     *
     * @return \DateTime
     */
    public function getDevConstComplAct()
    {
        return $this->devConstComplAct;
    }

    /**
     * Set devConstComplPrj
     *
     * @param  \DateTime $devConstComplPrj
     * @return Trident
     */
    public function setDevConstComplPrj($devConstComplPrj)
    {
        $this->devConstComplPrj = $devConstComplPrj;

        return $this;
    }

    /**
     * Get devConstComplPrj
     *
     * @return \DateTime
     */
    public function getDevConstComplPrj()
    {
        return $this->devConstComplPrj;
    }

    /**
     * Set devConstStartAct
     *
     * @param  \DateTime $devConstStartAct
     * @return Trident
     */
    public function setDevConstStartAct($devConstStartAct)
    {
        $this->devConstStartAct = $devConstStartAct;

        return $this;
    }

    /**
     * Get devConstStartAct
     *
     * @return \DateTime
     */
    public function getDevConstStartAct()
    {
        return $this->devConstStartAct;
    }

    /**
     * Set devConstStartPrj
     *
     * @param  \DateTime $devConstStartPrj
     * @return Trident
     */
    public function setDevConstStartPrj($devConstStartPrj)
    {
        $this->devConstStartPrj = $devConstStartPrj;

        return $this;
    }

    /**
     * Get devConstStartPrj
     *
     * @return \DateTime
     */
    public function getDevConstStartPrj()
    {
        return $this->devConstStartPrj;
    }

    /**
     * Set devPadAct
     *
     * @param  \DateTime $devPadAct
     * @return Trident
     */
    public function setDevPadAct($devPadAct)
    {
        $this->devPadAct = $devPadAct;

        return $this;
    }

    /**
     * Get devPadAct
     *
     * @return \DateTime
     */
    public function getDevPadAct()
    {
        return $this->devPadAct;
    }

    /**
     * Set devPadPrj
     *
     * @param  \DateTime $devPadPrj
     * @return Trident
     */
    public function setDevPadPrj($devPadPrj)
    {
        $this->devPadPrj = $devPadPrj;

        return $this;
    }

    /**
     * Get devPadPrj
     *
     * @return \DateTime
     */
    public function getDevPadPrj()
    {
        return $this->devPadPrj;
    }

    /**
     * Set finalCivilsAct
     *
     * @param  \DateTime $finalCivilsAct
     * @return Trident
     */
    public function setFinalCivilsAct($finalCivilsAct)
    {
        $this->finalCivilsAct = $finalCivilsAct;

        return $this;
    }

    /**
     * Get finalCivilsAct
     *
     * @return \DateTime
     */
    public function getFinalCivilsAct()
    {
        return $this->finalCivilsAct;
    }

    /**
     * Set finalCivilsPrj
     *
     * @param  \DateTime $finalCivilsPrj
     * @return Trident
     */
    public function setFinalCivilsPrj($finalCivilsPrj)
    {
        $this->finalCivilsPrj = $finalCivilsPrj;

        return $this;
    }

    /**
     * Get finalCivilsPrj
     *
     * @return \DateTime
     */
    public function getFinalCivilsPrj()
    {
        return $this->finalCivilsPrj;
    }

    /**
     * Set rentCommenceAct
     *
     * @param  \DateTime $rentCommenceAct
     * @return Trident
     */
    public function setRentCommenceAct($rentCommenceAct)
    {
        $this->rentCommenceAct = $rentCommenceAct;

        return $this;
    }

    /**
     * Get rentCommenceAct
     *
     * @return \DateTime
     */
    public function getRentCommenceAct()
    {
        return $this->rentCommenceAct;
    }

    /**
     * Set rentCommencePrj
     *
     * @param  \DateTime $rentCommencePrj
     * @return Trident
     */
    public function setRentCommencePrj($rentCommencePrj)
    {
        $this->rentCommencePrj = $rentCommencePrj;

        return $this;
    }

    /**
     * Get rentCommencePrj
     *
     * @return \DateTime
     */
    public function getRentCommencePrj()
    {
        return $this->rentCommencePrj;
    }

    /**
     * Set rezoneAppealAct
     *
     * @param  \DateTime $rezoneAppealAct
     * @return Trident
     */
    public function setRezoneAppealAct($rezoneAppealAct)
    {
        $this->rezoneAppealAct = $rezoneAppealAct;

        return $this;
    }

    /**
     * Get rezoneAppealAct
     *
     * @return \DateTime
     */
    public function getRezoneAppealAct()
    {
        return $this->rezoneAppealAct;
    }

    /**
     * Set rezoneAppealPrj
     *
     * @param  \DateTime $rezoneAppealPrj
     * @return Trident
     */
    public function setRezoneAppealPrj($rezoneAppealPrj)
    {
        $this->rezoneAppealPrj = $rezoneAppealPrj;

        return $this;
    }

    /**
     * Get rezoneAppealPrj
     *
     * @return \DateTime
     */
    public function getRezoneAppealPrj()
    {
        return $this->rezoneAppealPrj;
    }

    /**
     * Set siteRezoneAct
     *
     * @param  \DateTime $siteRezoneAct
     * @return Trident
     */
    public function setSiteRezoneAct($siteRezoneAct)
    {
        $this->siteRezoneAct = $siteRezoneAct;

        return $this;
    }

    /**
     * Get siteRezoneAct
     *
     * @return \DateTime
     */
    public function getSiteRezoneAct()
    {
        return $this->siteRezoneAct;
    }

    /**
     * Set siteRezonePrj
     *
     * @param  \DateTime $siteRezonePrj
     * @return Trident
     */
    public function setSiteRezonePrj($siteRezonePrj)
    {
        $this->siteRezonePrj = $siteRezonePrj;

        return $this;
    }

    /**
     * Get siteRezonePrj
     *
     * @return \DateTime
     */
    public function getSiteRezonePrj()
    {
        return $this->siteRezonePrj;
    }

    /**
     * Set warrantyComplAct
     *
     * @param  \DateTime $warrantyComplAct
     * @return Trident
     */
    public function setWarrantyComplAct($warrantyComplAct)
    {
        $this->warrantyComplAct = $warrantyComplAct;

        return $this;
    }

    /**
     * Get warrantyComplAct
     *
     * @return \DateTime
     */
    public function getWarrantyComplAct()
    {
        return $this->warrantyComplAct;
    }

    /**
     * Set warrantyComplPrj
     *
     * @param  \DateTime $warrantyComplPrj
     * @return Trident
     */
    public function setWarrantyComplPrj($warrantyComplPrj)
    {
        $this->warrantyComplPrj = $warrantyComplPrj;

        return $this;
    }

    /**
     * Get warrantyComplPrj
     *
     * @return \DateTime
     */
    public function getWarrantyComplPrj()
    {
        return $this->warrantyComplPrj;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
