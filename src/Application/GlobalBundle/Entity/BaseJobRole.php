<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobRoles
 * @ORM\MappedSuperclass
 */
class BaseJobRole
{
    /**
     * @var string
     * @ORM\Column(type="string", length=60)
     */
    protected $jobRole;

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
     * Set jobRole
     *
     * @param  string   $jobRole
     * @return JobRoles
     */
    public function setJobRole($jobRole)
    {
        $this->jobRole = $jobRole;

        return $this;
    }

    /**
     * Get jobRole
     *
     * @return string
     */
    public function getJobRole()
    {
        return $this->jobRole;
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
