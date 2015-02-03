<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpockDates1
 * @ORM\MappedSuperclass
 * @ORM\Table(name="spock_dates_1")
 */
class BaseSpockDates1
{
    /**
     * @var integer
     */
    protected $ownerMilestonesId;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $user;

    /**
     * @var integer
     */
    protected $id;

    /**
     * Set ownerMilestonesId
     *
     * @param  integer     $ownerMilestonesId
     * @return SpockDates1
     */
    public function setOwnerMilestonesId($ownerMilestonesId)
    {
        $this->ownerMilestonesId = $ownerMilestonesId;

        return $this;
    }

    /**
     * Get ownerMilestonesId
     *
     * @return integer
     */
    public function getOwnerMilestonesId()
    {
        return $this->ownerMilestonesId;
    }

    /**
     * Set date
     *
     * @param  \DateTime   $date
     * @return SpockDates1
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set timestamp
     *
     * @param  \DateTime   $timestamp
     * @return SpockDates1
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
     * @return SpockDates1
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
