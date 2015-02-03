<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Contacts
 * @ORM\MappedSuperclass
 */
class BaseContact
{
    /**
     * @var string
     * @ORM\Column(type="string", length=60)
     */
    protected $firstName;

    /**
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    protected $middleName;

    /**
     * @var string
     * @ORM\Column(type="string", length=60)
     */
    protected $lastName;

    /**
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     */
    protected $jobTitle;

    /**
     * @var string
     * @ORM\Column(type="string", length=40, nullable=true)
     * @Assert\Regex(
            pattern="~\(\d{3}\)\s\d{3}-\d{4}$~",
            message="Phone number must be in the format: (xxx) xxx-xxxx"
       )
     */
    protected $directPhone;

    /**
     * @var string
     * @ORM\Column(type="string", length=40, nullable=true)
     * @Assert\Regex(
            pattern="~\(\d{3}\)\s\d{3}-\d{4}$~",
            message="Phone number must be in the format: (xxx) xxx-xxxx"
       )
     */
    protected $mobilePhone;

    /**
     * @var string
     * @ORM\Column(type="string", length=60, nullable=true)
     * @Assert\Email()
     */
    protected $email;

    /**
     * @var string
     * @ORM\Column(type="string", length=255, nullable=true)
     * @Assert\Url()
     */
    protected $website;

    /**
     * @ORM\Column(type="string", length=7, nullable=true)
     * @Assert\Regex(
            pattern="~^#[A-Fa-f0-9]{6}$~",
            message="Must be a valid color hex value"
       )
     */
    protected $chartColor;

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
}
