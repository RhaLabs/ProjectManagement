<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * TridentMilestones
 * @ORM\MappedSuperclass
 * @ORM\Table(name="trident_milestones")
 */
class BaseTridentMilestones
{
    /**
     * @var string
     */
    protected $name;

    /**
     * Set name
     * @param  string            $name
     * @return TridentMilestones
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * Set timestamp
     *
     * @param  \DateTime         $timestamp
     * @return TridentMilestones
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
     * @var string
     */
    protected $user;

    /**
     * Set user
     *
     * @param  string            $user
     * @return TridentMilestones
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
     * @var integer
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
}
