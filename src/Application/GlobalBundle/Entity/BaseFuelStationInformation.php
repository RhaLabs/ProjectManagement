<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoreInformation
 * @ORM\MappedSuperclass
 */
class BaseFuelStationInformation
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $dispenserQuantity;

    public function getDispenserQuantity()
    {
        return $this->dispenserQuantity;
    }

    public function setDispenserQuantity($quantity = 0)
    {
        $this->dispenserQuantity = $quantity;

        return $this;
    }

    /**
     * @var integer
     * @ORM\Column(type="string")
     */
    protected $serviceBuildingLocation;

    public function getServiceBuuildingLocation()
    {
        return $this->serviceBuildingLocation;
    }

    public function setServiceBuildingLocation($location = null)
    {
        $this->serviceBuildingLocation = $location;

        return $this;
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
    }
}
