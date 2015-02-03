<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProjectContacts
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\ProjectContactsRepository")
 * @ORM\Table(name="project_contacts"
      )
 */
class ProjectContacts extends \Application\GlobalBundle\Entity\BaseProjectContacts
{
    /**
     * @var string
     * @ORM\ManyToOne(targetEntity="ProjectInformation", inversedBy="contacts")
     */
    private $project;
    public function addProject(\LimeTrail\Bundle\Entity\ProjectInformation $project)
    {
        $project->addContact($this);
        $this->project = $project;

        return $this;
    }
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="JobRole")
     */
    private $jobrole;
    public function addJobRole(\LimeTrail\Bundle\Entity\JobRole $jobrole)
    {
        $this->jobrole = $jobrole;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="projects")
     */
    private $contact;
    public function addContact(\LimeTrail\Bundle\Entity\Contact $contact)
    {
        $contact->addProject($this);
        $this->contact = $contact;

        return $this;
    }

    public function __construct()
    {
        $this->project = new ArrayCollection();
        $this->jobrole = new ArrayCollection();
        $this->contact = new ArrayCollection();
    }

    /**
     * Get jobrole
     *
     * @return \LimeTrail\Bundle\Entity\JobRole
     */
    public function getJobrole()
    {
        return $this->jobrole;
    }

    /**
     * Set contact
     *
     * @param  \LimeTrail\Bundle\Entity\JobRole $contact
     * @return ProjectContacts
     */
    public function setContact(\LimeTrail\Bundle\Entity\JobRole $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \LimeTrail\Bundle\Entity\JobRole
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set project
     *
     * @param  \LimeTrail\Bundle\Entity\ProjectInformation $project
     * @return ProjectContacts
     */
    public function setProject(\LimeTrail\Bundle\Entity\ProjectInformation $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get store
     *
     * @return \LimeTrail\Bundle\Entity\ProjectInformation
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set jobrole
     *
     * @param  \LimeTrail\Bundle\Entity\JobRole $jobrole
     * @return ProjectContacts
     */
    public function setJobrole(\LimeTrail\Bundle\Entity\JobRole $jobrole)
    {
        $this->jobrole = $jobrole;

        return $this;
    }
    
    public function __toString()
    {
      return get_class($this);
    }
}
