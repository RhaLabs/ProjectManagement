<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignOptions
 * @ORM\MappedSuperclass
 * @ORM\Table(name="design_options")
 */
class BaseDesignOptions
{
    /**
     * @var string
     */
    protected $designNamesId;

    /**
     * @var \DateTime
     */
    protected $detail;

    /**
     * @var \DateTime
     */
    protected $approval;

    /**
     * @var string
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
     * Set designNamesId
     *
     * @param  string        $designNamesId
     * @return DesignOptions
     */
    public function setDesignNamesId($designNamesId)
    {
        $this->designNamesId = $designNamesId;

        return $this;
    }

    /**
     * Get designNamesId
     *
     * @return string
     */
    public function getDesignNamesId()
    {
        return $this->designNamesId;
    }

    /**
     * Set detail
     *
     * @param  \DateTime     $detail
     * @return DesignOptions
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
     * @param  \DateTime     $approval
     * @return DesignOptions
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
     * @param  string        $detailUserEntered
     * @return DesignOptions
     */
    public function setDetailUserEntered($detailUserEntered)
    {
        $this->detailUserEntered = $detailUserEntered;

        return $this;
    }

    /**
     * Get detailUserEntered
     *
     * @return string
     */
    public function getDetailUserEntered()
    {
        return $this->detailUserEntered;
    }

    /**
     * Set aorCanUpdate
     *
     * @param  boolean       $aorCanUpdate
     * @return DesignOptions
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
     * @param  \DateTime     $timestamp
     * @return DesignOptions
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
     * @param  string        $user
     * @return DesignOptions
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
