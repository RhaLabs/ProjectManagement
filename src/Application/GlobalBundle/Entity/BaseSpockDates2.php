<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * SpockDates2
 * @ORM\MappedSuperclass
 * @ORM\Table(name="spock_dates_2")
 */
class BaseSpockDates2
{
    /**
     * @var \DateTime
     */
    protected $detail;

    /**
     * @var \DateTime
     */
    protected $approval;

    /**
     * @var \DateTime
     */
    protected $detailUserEntered;

    /**
     * @var boolean
     */
    protected $aorCanUpdate;

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
     * Set detail
     *
     * @param  \DateTime   $detail
     * @return SpockDates2
     */
    public function setDetail($detail)
    {
        $this->detail = $detail;

        return $this;
    }

    /**
     * Get detail
     *
     * @return \DateTime
     */
    public function getDetail()
    {
        return $this->detail;
    }

    /**
     * Set approval
     *
     * @param  \DateTime   $approval
     * @return SpockDates2
     */
    public function setApproval($approval)
    {
        $this->approval = $approval;

        return $this;
    }

    /**
     * Get approval
     *
     * @return \DateTime
     */
    public function getApproval()
    {
        return $this->approval;
    }

    /**
     * Set detailUserEntered
     *
     * @param  \DateTime   $detailUserEntered
     * @return SpockDates2
     */
    public function setDetailUserEntered($detailUserEntered)
    {
        $this->detailUserEntered = $detailUserEntered;

        return $this;
    }

    /**
     * Get detailUserEntered
     *
     * @return \DateTime
     */
    public function getDetailUserEntered()
    {
        return $this->detailUserEntered;
    }

    /**
     * Set aorCanUpdate
     *
     * @param  boolean     $aorCanUpdate
     * @return SpockDates2
     */
    public function setAorCanUpdate($aorCanUpdate)
    {
        $this->aorCanUpdate = $aorCanUpdate;

        return $this;
    }

    /**
     * Get aorCanUpdate
     *
     * @return boolean
     */
    public function getAorCanUpdate()
    {
        return $this->aorCanUpdate;
    }

    /**
     * Set timestamp
     *
     * @param  \DateTime   $timestamp
     * @return SpockDates2
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
     * @return SpockDates2
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
