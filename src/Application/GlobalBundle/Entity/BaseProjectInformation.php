<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectInformation
 * @ORM\MappedSuperclass
 *
 */
class BaseProjectInformation
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $Sequence;

    /**
     * @ORM\Column(type="string", length=20, nullable=true)
     */
    protected $isChanged;

    public function setIsChanged($val)
    {
        $this->isChanged = $val;

        return $this;
    }

    public function getIsChanged()
    {
        return $this->isChanged;
    }

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $projectPhase;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $confidential;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $combo;

    /**
     * @var boolean
     * @ORM\Column(type="boolean")
     */
    protected $manageSitesDifferent;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $sap;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $storeSquareFootage;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $increaseSquareFootage;

    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $prjTotalSquareFootage;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $actTotalSquareFootage;

        /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $cecComm;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $cOfOComm;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $aorComm;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $closeoutComm;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $podComm;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $gardenCtrRacks;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $gardenCtrSize;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $gardenCtrSf;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $gasStationApproval;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $ledParkingLights;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $liquor;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $cartCorralsReqd;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $pharmAppr;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $pharmSize;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $protoClass;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $protoMallEntry;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $dockProto;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $entranceProto;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $gardenCtrProto;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $tleProto;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $protoSize;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $shoppingCtrName;

    /**
     * @var string
     * @ORM\Column(type="string", length=75, nullable=true)
     */
    protected $shoppingCtrType;

    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $user;

    /**
     * @var string
     * @ORM\Column(type="string", length=60)
     */
    protected $locator;

    /**
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    protected $projectNumber;

    /**
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    protected $canonicalName;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $dateCreated;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    protected $dateModified;

    public function getDateModified()
    {
        return $this->dateCreated;
    }

    public function setDateModified($date)
    {
        $this->dateCreated = $date;

        return $this;
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
        $this->isChanged = null;
    }

    public function setProjectNumber($number)
    {
        $this->projectNumber = $number;

        return $this;
    }

    public function getProjectNumber()
    {
        return $this->projectNumber;
    }

    public function setCanonicalName($name)
    {
        $this->canonicalName = $name;

        return $this;
    }

    public function getCanonicalName()
    {
        return $this->canonicalName;
    }

    /**
     *
     */
    public function getDateCreated()
    {
        return $this->dateCreated;
    }

    /**
     * @return ProjectInformation
     */
    public function setDateCreated($date)
    {
        $this->dateCreated = $date;

        return $this;
    }

    /**
     * Set projectPhase
     *
     * @param  integer            $projectPhase
     * @return ProjectInformation
     */
    public function setProjectPhase($projectPhase)
    {
        $this->projectPhase = $projectPhase;

        return $this;
    }

    /**
     * Get projectPhase
     *
     * @return integer
     */
    public function getProjectPhase()
    {
        return $this->projectPhase;
    }

    /**
     * Set confidential
     *
     * @param  string             $confidential
     * @return ProjectInformation
     */
    public function setConfidential($confidential)
    {
        $this->confidential = $confidential;

        return $this;
    }

    /**
     * Get confidential
     *
     * @return string
     */
    public function getConfidential()
    {
        return $this->confidential;
    }

    /**
     * Set combo
     *
     * @param  boolean            $combo
     * @return ProjectInformation
     */
    public function setCombo($combo)
    {
        $this->combo = $combo;

        return $this;
    }

    /**
     * Get combo
     *
     * @return boolean
     */
    public function getCombo()
    {
        return $this->combo;
    }

    /**
     * Set manageSitesDifferent
     *
     * @param  boolean            $manageSitesDifferent
     * @return ProjectInformation
     */
    public function setManageSitesDifferent($manageSitesDifferent)
    {
        $this->manageSitesDifferent = $manageSitesDifferent;

        return $this;
    }

    /**
     * Get manageSitesDifferent
     *
     * @return boolean
     */
    public function getManageSitesDifferent()
    {
        return $this->manageSitesDifferent;
    }

    /**
     * Set sap
     *
     * @param  string             $sap
     * @return ProjectInformation
     */
    public function setSap($sap)
    {
        $this->sap = $sap;

        return $this;
    }

    /**
     * Get sap
     *
     * @return string
     */
    public function getSap()
    {
        return $this->sap;
    }

    /**
     * Set storeSquareFootage
     *
     * @param  integer            $storeSquareFootage
     * @return ProjectInformation
     */
    public function setStoreSquareFootage($storeSquareFootage)
    {
        $this->storeSquareFootage = $storeSquareFootage;

        return $this;
    }

    /**
     * Get storeSquareFootage
     *
     * @return integer
     */
    public function getStoreSquareFootage()
    {
        return $this->storeSquareFootage;
    }

    /**
     * Set increaseSquareFootage
     *
     * @param  integer            $increaseSquareFootage
     * @return ProjectInformation
     */
    public function setIncreaseSquareFootage($increaseSquareFootage)
    {
        $this->increaseSquareFootage = $increaseSquareFootage;

        return $this;
    }

    /**
     * Get increaseSquareFootage
     *
     * @return integer
     */
    public function getIncreaseSquareFootage()
    {
        return $this->increaseSquareFootage;
    }

    /**
     * Set prjTotalSquareFootage
     *
     * @param  integer            $prjTotalSquareFootage
     * @return ProjectInformation
     */
    public function setPrjTotalSquareFootage($prjTotalSquareFootage)
    {
        $this->prjTotalSquareFootage = $prjTotalSquareFootage;

        return $this;
    }

    /**
     * Get prjTotalSquareFootage
     *
     * @return integer
     */
    public function getPrjTotalSquareFootage()
    {
        return $this->prjTotalSquareFootage;
    }

    /**
     * Set actTotalSquareFootage
     *
     * @param  string             $actTotalSquareFootage
     * @return ProjectInformation
     */
    public function setActTotalSquareFootage($actTotalSquareFootage)
    {
        $this->actTotalSquareFootage = $actTotalSquareFootage;

        return $this;
    }

    /**
     * Get actTotalSquareFootage
     *
     * @return string
     */
    public function getActTotalSquareFootage()
    {
        return $this->actTotalSquareFootage;
    }

    /**
     * Set user
     *
     * @param  string             $user
     * @return ProjectInformation
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set locator
     *
     * @param  string             $locator
     * @return ProjectInformation
     */
    public function setLocator($locator)
    {
        $this->locator = $locator;

        return $this;
    }

    /**
     * Get locator
     *
     * @return string
     */
    public function getLocator()
    {
        return $this->locator;
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

    /**
     * Set Sequence
     *
     * @return ProjectInformation
     */
    public function setSequence($sequence)
    {
        $this->Sequence = $sequence;

        return $this;
    }

    /**
     * Get Sequence
     */
    public function getSequence()
    {
        return $this->Sequence;
    }

    /**
     * Set cecComm
     *
     * @param  string             $cecComm
     * @return ProjectInformation
     */
    public function setCecComm($cecComm)
    {
        $this->cecComm = $cecComm;

        return $this;
    }

    /**
     * Get cecComm
     *
     * @return string
     */
    public function getCecComm()
    {
        return $this->cecComm;
    }

    /**
     * Set cOfOComm
     *
     * @param  string             $cOfOComm
     * @return ProjectInformation
     */
    public function setCOfOComm($cOfOComm)
    {
        $this->cOfOComm = $cOfOComm;

        return $this;
    }

    /**
     * Get cOfOComm
     *
     * @return string
     */
    public function getCOfOComm()
    {
        return $this->cOfOComm;
    }

    /**
     * Set aorComm
     *
     * @param  string             $aorComm
     * @return ProjectInformation
     */
    public function setAorComm($aorComm)
    {
        $this->aorComm = $aorComm;

        return $this;
    }

    /**
     * Get aorComm
     *
     * @return string
     */
    public function getAorComm()
    {
        return $this->aorComm;
    }

    /**
     * Set closeoutComm
     *
     * @param  string             $closeoutComm
     * @return ProjectInformation
     */
    public function setCloseoutComm($closeoutComm)
    {
        $this->closeoutComm = $closeoutComm;

        return $this;
    }

    /**
     * Get closeoutComm
     *
     * @return string
     */
    public function getCloseoutComm()
    {
        return $this->closeoutComm;
    }

    /**
     * Set podComm
     *
     * @param  string             $podComm
     * @return ProjectInformation
     */
    public function setPodComm($podComm)
    {
        $this->podComm = $podComm;

        return $this;
    }

    /**
     * Get podComm
     *
     * @return string
     */
    public function getPodComm()
    {
        return $this->podComm;
    }

    /**
     * Set gardenCtrRacks
     *
     * @param  string             $gardenCtrRacks
     * @return ProjectInformation
     */
    public function setGardenCtrRacks($gardenCtrRacks)
    {
        $this->gardenCtrRacks = $gardenCtrRacks;

        return $this;
    }

    /**
     * Get gardenCtrRacks
     *
     * @return string
     */
    public function getGardenCtrRacks()
    {
        return $this->gardenCtrRacks;
    }

    /**
     * Set gardenCtrSize
     *
     * @param  string             $gardenCtrSize
     * @return ProjectInformation
     */
    public function setGardenCtrSize($gardenCtrSize)
    {
        $this->gardenCtrSize = $gardenCtrSize;

        return $this;
    }

    /**
     * Get gardenCtrSize
     *
     * @return string
     */
    public function getGardenCtrSize()
    {
        return $this->gardenCtrSize;
    }

    /**
     * Set gardenCtrSf
     *
     * @param  string             $gardenCtrSf
     * @return ProjectInformation
     */
    public function setGardenCtrSf($gardenCtrSf)
    {
        $this->gardenCtrSf = $gardenCtrSf;

        return $this;
    }

    /**
     * Get gardenCtrSf
     *
     * @return string
     */
    public function getGardenCtrSf()
    {
        return $this->gardenCtrSf;
    }

    /**
     * Set gasStationApproval
     *
     * @param  string             $gasStationApproval
     * @return ProjectInformation
     */
    public function setGasStationApproval($gasStationApproval)
    {
        $this->gasStationApproval = $gasStationApproval;

        return $this;
    }

    /**
     * Get gasStationApproval
     *
     * @return string
     */
    public function getGasStationApproval()
    {
        return $this->gasStationApproval;
    }

    /**
     * Set ledParkingLights
     *
     * @param  string             $ledParkingLights
     * @return ProjectInformation
     */
    public function setLedParkingLights($ledParkingLights)
    {
        $this->ledParkingLights = $ledParkingLights;

        return $this;
    }

    /**
     * Get ledParkingLights
     *
     * @return string
     */
    public function getLedParkingLights()
    {
        return $this->ledParkingLights;
    }

    /**
     * Set liquor
     *
     * @param  string             $liquor
     * @return ProjectInformation
     */
    public function setLiquor($liquor)
    {
        $this->liquor = $liquor;

        return $this;
    }

    /**
     * Get liquor
     *
     * @return string
     */
    public function getLiquor()
    {
        return $this->liquor;
    }

    /**
     * Set cartCorralsReqd
     *
     * @param  string             $cartCorralsReqd
     * @return ProjectInformation
     */
    public function setCartCorralsReqd($cartCorralsReqd)
    {
        $this->cartCorralsReqd = $cartCorralsReqd;

        return $this;
    }

    /**
     * Get cartCorralsReqd
     *
     * @return string
     */
    public function getCartCorralsReqd()
    {
        return $this->cartCorralsReqd;
    }

    /**
     * Set pharmAppr
     *
     * @param  string             $pharmAppr
     * @return ProjectInformation
     */
    public function setPharmAppr($pharmAppr)
    {
        $this->pharmAppr = $pharmAppr;

        return $this;
    }

    /**
     * Get pharmAppr
     *
     * @return string
     */
    public function getPharmAppr()
    {
        return $this->pharmAppr;
    }

    /**
     * Set pharmSize
     *
     * @param  string             $pharmSize
     * @return ProjectInformation
     */
    public function setPharmSize($pharmSize)
    {
        $this->pharmSize = $pharmSize;

        return $this;
    }

    /**
     * Get pharmSize
     *
     * @return string
     */
    public function getPharmSize()
    {
        return $this->pharmSize;
    }

    /**
     * Set protoClass
     *
     * @param  string             $protoClass
     * @return ProjectInformation
     */
    public function setProtoClass($protoClass)
    {
        $this->protoClass = $protoClass;

        return $this;
    }

    /**
     * Get protoClass
     *
     * @return string
     */
    public function getProtoClass()
    {
        return $this->protoClass;
    }

    /**
     * Set protoMallEntry
     *
     * @param  string             $protoMallEntry
     * @return ProjectInformation
     */
    public function setProtoMallEntry($protoMallEntry)
    {
        $this->protoMallEntry = $protoMallEntry;

        return $this;
    }

    /**
     * Get protoMallEntry
     *
     * @return string
     */
    public function getProtoMallEntry()
    {
        return $this->protoMallEntry;
    }

    /**
     * Set dockProto
     *
     * @param  string             $dockProto
     * @return ProjectInformation
     */
    public function setDockProto($dockProto)
    {
        $this->dockProto = $dockProto;

        return $this;
    }

    /**
     * Get dockProto
     *
     * @return string
     */
    public function getDockProto()
    {
        return $this->dockProto;
    }

    /**
     * Set entranceProto
     *
     * @param  string             $entranceProto
     * @return ProjectInformation
     */
    public function setEntranceProto($entranceProto)
    {
        $this->entranceProto = $entranceProto;

        return $this;
    }

    /**
     * Get entranceProto
     *
     * @return string
     */
    public function getEntranceProto()
    {
        return $this->entranceProto;
    }

    /**
     * Set gardenCtrProto
     *
     * @param  string             $gardenCtrProto
     * @return ProjectInformation
     */
    public function setGardenCtrProto($gardenCtrProto)
    {
        $this->gardenCtrProto = $gardenCtrProto;

        return $this;
    }

    /**
     * Get gardenCtrProto
     *
     * @return string
     */
    public function getGardenCtrProto()
    {
        return $this->gardenCtrProto;
    }

    /**
     * Set tleProto
     *
     * @param  string             $tleProto
     * @return ProjectInformation
     */
    public function setTleProto($tleProto)
    {
        $this->tleProto = $tleProto;

        return $this;
    }

    /**
     * Get tleProto
     *
     * @return string
     */
    public function getTleProto()
    {
        return $this->tleProto;
    }

    /**
     * Set protoSize
     *
     * @param  string             $protoSize
     * @return ProjectInformation
     */
    public function setProtoSize($protoSize)
    {
        $this->protoSize = $protoSize;

        return $this;
    }

    /**
     * Get protoSize
     *
     * @return string
     */
    public function getProtoSize()
    {
        return $this->protoSize;
    }

    /**
     * Set shoppingCtrName
     *
     * @param  string             $shoppingCtrName
     * @return ProjectInformation
     */
    public function setShoppingCtrName($shoppingCtrName)
    {
        $this->shoppingCtrName = $shoppingCtrName;

        return $this;
    }

    /**
     * Get shoppingCtrName
     *
     * @return string
     */
    public function getShoppingCtrName()
    {
        return $this->shoppingCtrName;
    }

    /**
     * Set shoppingCtrType
     *
     * @param  string             $shoppingCtrType
     * @return ProjectInformation
     */
    public function setShoppingCtrType($shoppingCtrType)
    {
        $this->shoppingCtrType = $shoppingCtrType;

        return $this;
    }

    /**
     * Get shoppingCtrType
     *
     * @return string
     */
    public function getShoppingCtrType()
    {
        return $this->shoppingCtrType;
    }
}
