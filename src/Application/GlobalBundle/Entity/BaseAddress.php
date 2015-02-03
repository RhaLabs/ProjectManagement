<?php

namespace Application\GlobalBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Address
 * @ORM\MappedSuperclass
 */
class BaseAddress
{
    /**
     * @var string
     * @ORM\Column(type="string", length=120)
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min = 2)
     */
    protected $address;

    /**
     * @var string
     * @ORM\Column(type="string", length=20)
     */
    protected $suite;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=5, precision=20)
     */
    protected $longitude;

    /**
     * @var float
     * @ORM\Column(type="decimal", scale=5, precision=20)
     */
    protected $latitude;

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
     * Set address
     *
     * @param  string  $address
     * @return Address
     */
    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return string
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set suite
     *
     * @param  string  $suite
     * @return Address
     */
    public function setSuite($suite)
    {
        $this->suite = $suite;

        return $this;
    }

    /**
     * Get suite
     *
     * @return string
     */
    public function getSuite()
    {
        return $this->suite;
    }

    /**
     * Set longitude
     *
     * @param  float   $longitude
     * @return Address
     */
    public function setLongitude($longitude)
    {
        $this->longitude = $longitude;

        return $this;
    }

    /**
     * Get longitude
     *
     * @return float
     */
    public function getLongitude()
    {
        return $this->longitude;
    }

    /**
     * Set latitude
     *
     * @param  float   $latitude
     * @return Address
     */
    public function setLatitude($latitude)
    {
        $this->latitude = $latitude;

        return $this;
    }

    /**
     * Get latitude
     *
     * @return float
     */
    public function getLatitude()
    {
        return $this->latitude;
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
