<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * PlanTypes
 *
 * @ORM\Table(name="plan_types", indexes=
 {
 @ORM\Index(name="name_idx", columns={"name"})
 }
 )
 */
class PlanTypes
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var \DateTime
     */
    private $timestamp;

    /**
     * @var string
     */
    private $user;

    /**
     * @var integer
     */
    private $id;

    /**
     * Set name
     *
     * @param  string    $name
     * @return PlanTypes
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set timestamp
     *
     * @param  \DateTime $timestamp
     * @return PlanTypes
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
     * @param  string    $user
     * @return PlanTypes
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
