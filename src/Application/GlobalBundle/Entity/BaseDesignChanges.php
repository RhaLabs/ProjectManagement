<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * DesignChanges
 * @ORM\MappedSuperclass
 */
class BaseDesignChanges
{
    /**
     * @var integer
     */
    protected $planTypesId;

    /**
     * @var \DateTime
     */
    protected $otpProj;

    /**
     * @var \DateTime
     */
    protected $otpAct;

    /**
     * @var \DateTime
     */
    protected $permitProj;

    /**
     * @var \DateTime
     */
    protected $permitAct;

    /**
     * @var string
     */
    protected $comments;

    /**
     * @var integer
     */
    protected $requestedById;

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
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Set planTypesId
     *
     * @param  integer       $planTypesId
     * @return DesignChanges
     */
    public function setPlanTypesId($planTypesId)
    {
        $this->planTypesId = $planTypesId;

        return $this;
    }

    /**
     * Get planTypesId
     *
     * @return integer
     */
    public function getPlanTypesId()
    {
        return $this->planTypesId;
    }

    /**
     * Set otpProj
     *
     * @param  \DateTime     $otpProj
     * @return DesignChanges
     */
    public function setOtpProj($otpProj)
    {
        $this->otpProj = $otpProj;

        return $this;
    }

    /**
     * Get otpProj
     *
     * @return \DateTime
     */
    public function getOtpProj()
    {
        return $this->otpProj;
    }

    /**
     * Set otpAct
     *
     * @param  \DateTime     $otpAct
     * @return DesignChanges
     */
    public function setOtpAct($otpAct)
    {
        $this->otpAct = $otpAct;

        return $this;
    }

    /**
     * Get otpAct
     *
     * @return \DateTime
     */
    public function getOtpAct()
    {
        return $this->otpAct;
    }

    /**
     * Set permitProj
     *
     * @param  \DateTime     $permitProj
     * @return DesignChanges
     */
    public function setPermitProj($permitProj)
    {
        $this->permitProj = $permitProj;

        return $this;
    }

    /**
     * Get permitProj
     *
     * @return \DateTime
     */
    public function getPermitProj()
    {
        return $this->permitProj;
    }

    /**
     * Set permitAct
     *
     * @param  \DateTime     $permitAct
     * @return DesignChanges
     */
    public function setPermitAct($permitAct)
    {
        $this->permitAct = $permitAct;

        return $this;
    }

    /**
     * Get permitAct
     *
     * @return \DateTime
     */
    public function getPermitAct()
    {
        return $this->permitAct;
    }

    /**
     * Set comments
     *
     * @param  string        $comments
     * @return DesignChanges
     */
    public function setComments($comments)
    {
        $this->comments = $comments;

        return $this;
    }

    /**
     * Get comments
     *
     * @return string
     */
    public function getComments()
    {
        return $this->comments;
    }

    /**
     * Set requestedById
     *
     * @param  integer       $requestedById
     * @return DesignChanges
     */
    public function setRequestedById($requestedById)
    {
        $this->requestedById = $requestedById;

        return $this;
    }

    /**
     * Get requestedById
     *
     * @return integer
     */
    public function getRequestedById()
    {
        return $this->requestedById;
    }

    /**
     * Set timestamp
     *
     * @param  \DateTime     $timestamp
     * @return DesignChanges
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
     * @return DesignChanges
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
