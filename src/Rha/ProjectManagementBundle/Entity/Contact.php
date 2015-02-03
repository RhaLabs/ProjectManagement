<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contacts
 * @ORM\Entity
 * @ORM\Table(name="contacts",
    indexes={
        @ORM\Index(name="firsname_idx", columns={"firstName"}),
        @ORM\Index(name="lastname_idx", columns={"lastName"}),
        @ORM\Index(name="email_idx", columns={"email"})
      },
    uniqueConstraints={
      @ORM\UniqueConstraint(name="unique_idx",
        columns=
          {
            "email",
            "firstName",
            "lastName"
          }
        )
      }
    )
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\ContactRepository")
 */
class Contact
{
    /**
     * @var string
     * @ORM\Column(type="string", length=60)
     */
    private $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $middleName;

    /**
     * @var string
     * @ORM\Column(type="string", length=60)
     */
    private $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    private $jobTitle;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Office", inversedBy="contacts")
     * @ORM\JoinColumn(name="office", referencedColumnName="id")
     */
    private $office;
    public function addOffice(\Rha\ProjectManagementBundle\Entity\Office $office)
    {
        $office->addContact($this);
        $this->office = $office;
    }

    /**
     * @ORM\OneToMany(targetEntity="ProjectContacts", mappedBy="contact")
     */
    private $projects;
    public function addProject(\Rha\ProjectManagementBundle\Entity\ProjectContacts $projects)
    {
        $this->projects[] = $projects;
    }
    /*
     * @ORM\ManyToMany(targetEntity="JobRole")
     * @ORM\JoinTable(name="contacts_jobroles",
               joinColumns={@ORM\JoinColumn(name="contacts",
                    referencedColumnName="id")},
               inverseJoinColumns={@ORM\JoinColumn(name="jobroles",
                    referencedColumnName="id")}
            )
      */
      private $jobroles;
    public function addJobRole($jobrole)
    {
        $this->jobroles[] = jobrole;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=40, nullable=true)
     * @Assert\Regex(
            pattern="~\(\d{3}\)\s\d{3}-\d{4}$~",
            message="Phone number must be in the format: (xxx) xxx-xxxx"
       )
     */
    private $directPhone;

    /**
     * @var string
     * @ORM\Column(type="string", length=40, nullable=true)
     * @Assert\Regex(
            pattern="~\(\d{3}\)\s\d{3}-\d{4}$~",
            message="Phone number must be in the format: (xxx) xxx-xxxx"
       )
     */
    private $mobilePhone;

    /**
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     * @Assert\Email()
     */
    private $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    private $website;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     * @Assert\Regex(
            pattern="~^#[A-Fa-f0-9]{6}$~",
            message="Must be a valid color hex value"
       )
     */
    private $chartColor;

    /**
     * @ORM\OneToMany(targetEntity="ProjectInformation", mappedBy="aorContact")
     */
    private $aorContact;

    public function addAorContact(\Rha\ProjectManagementBundle\Entity\ProjectInformation $Type)
    {
        $this->aorContact[] = $Type;
    }

    /**
     * @ORM\OneToMany(targetEntity="ProjectCriteria", mappedBy="ArchitectOfRecord")
     */
    private $ArchitectOfRecord;

    public function addArchitectOfRecord(\Rha\ProjectManagementBundle\Entity\ProjectCriteria $Type)
    {
        $this->ArchitectOfRecord[] = $Type;
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        $this->projects = new ArrayCollection();

        $this->jobroles = new ArrayCollection();

        $this->aorContact = new ArrayCollection();

        $this->ArchitectOfRecord = new ArrayCollection();
    }

    /**
     * set chart color
     */
    public function setChartColor($color)
    {
        $this->chartColor = $color;

        return $this;
    }

    public function getChartColor()
    {
        return $this->chartColor;
    }

    /**
     * Set firstName
     *
     * @param  string   $firstName
     * @return Contacts
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set middleName
     *
     * @param  string   $middleName
     * @return Contacts
     */
    public function setMiddleName($middleName)
    {
        $this->middleName = $middleName;

        return $this;
    }

    /**
     * Get middleName
     *
     * @return string
     */
    public function getMiddleName()
    {
        return $this->middleName;
    }

    /**
     * Set lastName
     *
     * @param  string   $lastName
     * @return Contacts
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set jobTitle
     *
     * @param  string   $jobTitle
     * @return Contacts
     */
    public function setJobTitle($jobTitle)
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    /**
     * Get jobTitle
     *
     * @return string
     */
    public function getJobTitle()
    {
        return $this->jobTitle;
    }

    /**
     * Set directPhone
     *
     * @param  string   $directPhone
     * @return Contacts
     */
    public function setDirectPhone($directPhone)
    {
        $this->directPhone = $directPhone;

        return $this;
    }

    /**
     * Get directPhone
     *
     * @return string
     */
    public function getDirectPhone()
    {
        return $this->directPhone;
    }

    /**
     * Set mobilePhone
     *
     * @param  string   $mobilePhone
     * @return Contacts
     */
    public function setMobilePhone($mobilePhone)
    {
        $this->mobilePhone = $mobilePhone;

        return $this;
    }

    /**
     * Get mobilePhone
     *
     * @return string
     */
    public function getMobilePhone()
    {
        return $this->mobilePhone;
    }

    /**
     * Set email
     *
     * @param  string   $email
     * @return Contacts
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set timestamp
     *
     * @param  string   $timestamp
     * @return Contacts
     */
    public function setTimestamp($timestamp)
    {
        $this->timestamp = $timestamp;

        return $this;
    }

    /**
     * Get timestamp
     *
     * @return string
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * Set user
     *
     * @param  string   $user
     * @return Contacts
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

    /**
     * Set company
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Company $company
     * @return Contact
     */
    public function setCompany(\Rha\ProjectManagementBundle\Entity\Office $office)
    {
        $this->offuce = $office;

        return $this;
    }

    /**
     * Get company
     *
     * @return \Rha\ProjectManagementBundle\Entity\Company
     */
    public function getOffice()
    {
        return $this->office;
    }

    /**
     * Set website
     *
     * @param  string  $website
     * @return Contact
     */
    public function setWebsite($website)
    {
        $this->website = $website;

        return $this;
    }

    /**
     * Get website
     *
     * @return string
     */
    public function getWebsite()
    {
        return $this->website;
    }

    /**
     * Remove projects
     *
     * @param \Rha\ProjectManagementBundle\Entity\ProjectInformation $projects
     */
    public function removeProject(\Rha\ProjectManagementBundle\Entity\ProjectInformation $projects)
    {
        $this->projects->removeElement($projects);
    }

    /**
     * Remove aorContact
     */
    public function removeAorContact(\Rha\ProjectManagementBundle\Entity\ProjectInformation $contact)
    {
        $this->aorContact->removeElement($contact);
    }

    /**
     * Get projects
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getProjects()
    {
        return $this->projects;
    }
}
