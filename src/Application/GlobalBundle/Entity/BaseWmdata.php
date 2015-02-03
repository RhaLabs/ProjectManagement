<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Wmdata
 * @ORM\MappedSuperclass
 * @ORM\Table(name="wmdata")
 */
class BaseWmdata
{
    /**
     * @var integer
     */
    protected $recordId;

    /**
     * @var integer
     */
    protected $storeInformationId;

    /**
     * @var integer
     */
    protected $projectInformationId;

    /**
     * @var integer
     */
    protected $projectContactId;

    /**
     * @var integer
     */
    protected $tridentDatesId;

    /**
     * @var integer
     */
    protected $spockDates1Id;

    /**
     * @var integer
     */
    protected $spockDates2Id;

    /**
     * @var integer
     */
    protected $designChangesId;

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
     * Set recordId
     *
     * @param  integer $recordId
     * @return Wmdata
     */
    public function setRecordId($recordId)
    {
        $this->recordId = $recordId;

        return $this;
    }

    /**
     * Get recordId
     *
     * @return integer
     */
    public function getRecordId()
    {
        return $this->recordId;
    }

    /**
     * Set storeInformationId
     *
     * @param  integer $storeInformationId
     * @return Wmdata
     */
    public function setStoreInformationId($storeInformationId)
    {
        $this->storeInformationId = $storeInformationId;

        return $this;
    }

    /**
     * Get storeInformationId
     *
     * @return integer
     */
    public function getStoreInformationId()
    {
        return $this->storeInformationId;
    }

    /**
     * Set projectInformationId
     *
     * @param  integer $projectInformationId
     * @return Wmdata
     */
    public function setProjectInformationId($projectInformationId)
    {
        $this->projectInformationId = $projectInformationId;

        return $this;
    }

    /**
     * Get projectInformationId
     *
     * @return integer
     */
    public function getProjectInformationId()
    {
        return $this->projectInformationId;
    }

    /**
     * Set projectContactId
     *
     * @param  integer $projectContactId
     * @return Wmdata
     */
    public function setProjectContactId($projectContactId)
    {
        $this->projectContactId = $projectContactId;

        return $this;
    }

    /**
     * Get projectContactId
     *
     * @return integer
     */
    public function getProjectContactId()
    {
        return $this->projectContactId;
    }

    /**
     * Set tridentDatesId
     *
     * @param  integer $tridentDatesId
     * @return Wmdata
     */
    public function setTridentDatesId($tridentDatesId)
    {
        $this->tridentDatesId = $tridentDatesId;

        return $this;
    }

    /**
     * Get tridentDatesId
     *
     * @return integer
     */
    public function getTridentDatesId()
    {
        return $this->tridentDatesId;
    }

    /**
     * Set spockDates1Id
     *
     * @param  integer $spockDates1Id
     * @return Wmdata
     */
    public function setSpockDates1Id($spockDates1Id)
    {
        $this->spockDates1Id = $spockDates1Id;

        return $this;
    }

    /**
     * Get spockDates1Id
     *
     * @return integer
     */
    public function getSpockDates1Id()
    {
        return $this->spockDates1Id;
    }

    /**
     * Set spockDates2Id
     *
     * @param  integer $spockDates2Id
     * @return Wmdata
     */
    public function setSpockDates2Id($spockDates2Id)
    {
        $this->spockDates2Id = $spockDates2Id;

        return $this;
    }

    /**
     * Get spockDates2Id
     *
     * @return integer
     */
    public function getSpockDates2Id()
    {
        return $this->spockDates2Id;
    }

    /**
     * Set designChangesId
     *
     * @param  integer $designChangesId
     * @return Wmdata
     */
    public function setDesignChangesId($designChangesId)
    {
        $this->designChangesId = $designChangesId;

        return $this;
    }

    /**
     * Get designChangesId
     *
     * @return integer
     */
    public function getDesignChangesId()
    {
        return $this->designChangesId;
    }

    /**
     * Set timestamp
     *
     * @param  \DateTime $timestamp
     * @return Wmdata
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
     * @param  string $user
     * @return Wmdata
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
