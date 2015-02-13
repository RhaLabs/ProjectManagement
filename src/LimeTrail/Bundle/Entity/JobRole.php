<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * JobRoles
 * @ORM\Entity
 * @ORM\Table(name="job_role", indexes=
 {
 @ORM\Index(name="jobrole_idx", columns={"jobRole"})
 }
 )
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\JobRoleRepository")
 */
class JobRole
{
    /**
     * @var string
     * @ORM\Column(type="string", length=60)
     */
    private $jobRole;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
