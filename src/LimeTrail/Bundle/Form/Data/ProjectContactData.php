<?php

namespace LimeTrail\Bundle\Form\Data;

use Symfony\Component\Validator\Constraints as Assert;

class ProjectContactData
{
    public $jobRole;
    
    /**
     * @Assert\NotBlank()
     */
    public $firstName;
    
    /**
     * @Assert\NotBlank()
     */
    public $lastName;
    
    public $middleName;
    
    public $jobTitle;

    /**
     * @Assert\Regex(
            pattern="~\(\d{3}\)\s\d{3}-\d{4}$~",
            message="Phone number must be in the format: (xxx) xxx-xxxx"
       )
     */
    public $directPhone;

    /**
     * @Assert\Regex(
            pattern="~\(\d{3}\)\s\d{3}-\d{4}$~",
            message="Phone number must be in the format: (xxx) xxx-xxxx"
       )
     */
    public $mobilePhone;

    /**
     * @Assert\Email()
     */
    public $email;

    /**
     * @Assert\Url()
     */
    public $website;

    /**
     * @Assert\Regex(
            pattern="~^#[A-Fa-f0-9]{6}$~",
            message="Must be a valid color hex value"
       )
     */
    public $chartColor;
    
    public $project;
    
    public $contact;
    
    public $projectContact;
    
    public function __construct($contact, $jobRole, $projectcontact = null, $project = null)
    {
        $this->contact = $contact;
        
        if ($jobRole) {
            $this->jobRole = $jobRole->getJobRole();
        }
        
        if ($contact) {
            $this->firstName = $contact->getFirstName();
            $this->middleName = $contact->getMiddleName();
            $this->lastName = $contact->getLastName();
            $this->jobTitle = $contact->getJobTitle();
            $this->directPhone = $contact->getDirectPhone();
            $this->mobilePhone = $contact->getMobilePhone();
            $this->email = $contact->getEmail();
            $this->website = $contact->getWebsite();
            $this->chartColor = $contact->getChartColor();
        }
        
        $this->projectContact = $projectcontact;
        
        $this->project = $project;
    }
}
