<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoreInformation
 * @ORM\MappedSuperclass
 */
class BaseStoreInformation
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $storeNumber;

    /**
     * Set number
     * @param  integer          $number
     * @return StoreInformation
     */
    public function setStoreNumber($number)
    {
        $this->storeNumber = $number;

        return $this;
    }

    /**
     * Get number
     * @return integer
     */
    public function getStoreNumber()
    {
        return $this->storeNumber;
    }

    /**
     * @var string
     */
    protected $user;

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
