<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProgramYear
 * @ORM\MappedSuperclass
 */
class BaseProgramYear
{
    /**
     * @var \DateTime
     * @ORM\Column(type="integer", unique=true)
     */
    protected $year;

    /**
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * @var string
     * @ORM\Column(type="string", length=40)
     */
    protected $user;

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
     * Set projectedYear
     *
     * @param  integer     $Year
     * @return ProgramYear
     */
    public function setYear($Year)
    {
        $this->year = $Year;

        return $this;
    }

    /**
     * Get projectedYear
     *
     * @return integer
     */
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set timestamp
     *
     * @param  \DateTime   $timestamp
     * @return ProgramYear
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return \DateTime
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set user
     *
     * @param  string      $user
     * @return ProgramYear
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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
