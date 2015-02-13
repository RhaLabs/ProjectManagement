<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\ProductionRepository")
 * @ORM\Table(name="production", indexes=
 {
 @ORM\Index(name="date_idx", columns={"createDate"})
 }
 )
 */
class Production extends \Application\GlobalBundle\Entity\BaseEntity
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $basePrototype;

    public function getBasePrototype()
    {
        return $this->basePrototype;
    }

    public function setBasePrototype($value)
    {
        $this->basePrototype = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $basePrototypeControl;

    public function getBasePrototypeControl()
    {
        return $this->basePrototypeControl;
    }

    public function setBasePrototypeControl($value)
    {
        $this->basePrototypeControl = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $removeTLE;

    public function getRemoveTLE()
    {
        return $this->removeTLE;
    }

    public function setRemoveTLE($value)
    {
        $this->removeTLE = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $removeTLEControl;

    public function getRemoveTLEControl()
    {
        return $this->removeTLEControl;
    }

    public function setRemoveTLEControl($value)
    {
        $this->removeTLEControl = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $precastConcrete;

    public function getPrecastConcrete()
    {
        return $this->precastConcrete;
    }

    public function setPrecastConcrete($value)
    {
        $this->precastConcrete = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $precastConcreteControl;

    public function getPrecastConcreteControl()
    {
        return $this->precastConcreteControl;
    }

    public function setPrecastConcreteControl($value)
    {
        $this->precastConcreteControl = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $baleAndPalletScreening;

    public function getBaleAndPalletScreening()
    {
        return $this->baleAndPalletScreening;
    }

    public function setBaleAndPalletScreening($value)
    {
        $this->baleAndPalletScreening = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $dockScreening;

    public function getDockScreening()
    {
        return $this->dockScreening;
    }

    public function setDockScreening($value)
    {
        $this->dockScreening = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $firePump;

    public function getFirePump()
    {
        return $this->firePump;
    }

    public function setFirePump($value)
    {
        $this->firePump = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $elevationUpgrade;

    public function getElevationUpgrade()
    {
        return $this->elevationUpgrade;
    }

    public function setElevationUpgrade($value)
    {
        $this->elevationUpgrade = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $elevationUpgradeControl;

    public function getElevationUpgradeControl()
    {
        return $this->elevationUpgradeControl;
    }

    public function setElevationUpgradeControl($value)
    {
        $this->elevationUpgradeControl = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $specialFootPrint;

    public function getSpecialFootPrint()
    {
        return $this->specialFootPrint;
    }

    public function setSpecialFootPrint($value)
    {
        $this->specialFootPrint = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $specialFootPrintControl;

    public function getSpecialFootPrintControl()
    {
        return $this->specialFootPrintControl;
    }

    public function setSpecialFootPrintControl($value)
    {
        $this->specialFootPrintControl = $value;

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
    protected $fuelStationControl;

    public function getFuelStationControl()
    {
        return $this->fuelStationControl;
    }

    public function setFuelStationControl($value)
    {
        $this->fuelStationControl = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $liquorBox;

    public function getLiquorBox()
    {
        return $this->liquorBox;
    }

    public function setLiquorBox($value)
    {
        $this->liquorBox = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $liquorBoxControl;

    public function getLiquorBoxControl()
    {
        return $this->liquorBoxControl;
    }

    public function setLiquorBoxControl($value)
    {
        $this->liquorBoxControl = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $highWind;

    public function getHighWind()
    {
        return $this->highWind;
    }

    public function setHighWind($value)
    {
        $this->highWind = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $highWindControl;

    public function getHighWindControl()
    {
        return $this->highWindControl;
    }

    public function setHighWindControl($value)
    {
        $this->highWindControl = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $seismic;

    public function getSeismic()
    {
        return $this->seismic;
    }

    public function setSeismic($value)
    {
        $this->seismic = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $seismicControl;

    public function getSeismicControl()
    {
        return $this->seismicControl;
    }

    public function setSeismicControl($value)
    {
        $this->seismicControl = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $other;

    public function getOther()
    {
        return $this->other;
    }

    public function setOther($value)
    {
        $this->other = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $otherControl;

    public function getOtherControl()
    {
        return $this->otherControl;
    }

    public function setOtherControl($value)
    {
        $this->otherControl = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $permitSubmittal;

    public function getPermitSubmittal()
    {
        return $this->permitSubmittal;
    }

    public function setPermitSubmittal($value)
    {
        $this->permitSubmittal = $value;

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
    protected $shellPlan;

    public function getShellPlan()
    {
        return $this->shellPlan;
    }

    public function setShellPlan($value)
    {
        $this->shellPlan = $value;

        return $this;
    }
}
