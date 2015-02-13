<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * ProjectContacts
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\ProjectContactsRepository")
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
    public function addProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $project)
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
    public function addJobRole(\Rha\ProjectManagementBundle\Entity\JobRole $jobrole)
    {
        $this->jobrole = $jobrole;

        return $this;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Contact", inversedBy="projects")
     */
    private $contact;
    public function addContact(\Rha\ProjectManagementBundle\Entity\Contact $contact)
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
     * @return \Rha\ProjectManagementBundle\Entity\JobRole
     */
    public function getJobrole()
    {
        return $this->jobrole;
    }

    /**
     * Set contact
     *
     * @param  \Rha\ProjectManagementBundle\Entity\JobRole $contact
     * @return ProjectContacts
     */
    public function setContact(\Rha\ProjectManagementBundle\Entity\JobRole $contact = null)
    {
        $this->contact = $contact;

        return $this;
    }

    /**
     * Get contact
     *
     * @return \Rha\ProjectManagementBundle\Entity\JobRole
     */
    public function getContact()
    {
        return $this->contact;
    }

    /**
     * Set project
     *
     * @param  \Rha\ProjectManagementBundle\Entity\ProjectInformation $project
     * @return ProjectContacts
     */
    public function setProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $project)
    {
        $this->project = $project;

        return $this;
    }

    /**
     * Get store
     *
     * @return \Rha\ProjectManagementBundle\Entity\ProjectInformation
     */
    public function getProject()
    {
        return $this->project;
    }

    /**
     * Set jobrole
     *
     * @param  \Rha\ProjectManagementBundle\Entity\JobRole $jobrole
     * @return ProjectContacts
     */
    public function setJobrole(\Rha\ProjectManagementBundle\Entity\JobRole $jobrole)
    {
        $this->jobrole = $jobrole;

        return $this;
    }
}
