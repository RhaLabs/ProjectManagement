<?php

namespace LimeTrail\Bundle\Model;

use LimeTrail\Bundle\Form\Data\ProjectContactData;
use LimeTrail\Bundle\Entity\Contact;
use LimeTrail\Bundle\Entity\JobRole;
use LimeTrail\Bundle\Provider\ContactProvider;

class ProjectContactModel
{
    protected $provider;

    protected $formData;

    protected $entityResult;

    public function __construct(ProjectContactData $formData, ContactProvider $provider)
    {
        $this->provider = $provider;

        $this->formData = $formData;
    }

    public function ProcessFormData()
    {
        $jobrole = $this->formData->jobRole;
        $projectcontact = $this->formData->projectContact;

        if (!$projectcontact) {
            $projectcontact = new ProjectContact();

            $projectcontact->addProject($this->formData->project);

            $contact = $this->formData->contact;
            $projectcontact->addContact($contact);
        } else {
            $contact = $projectcontact->getContact();

            $contact->getFirsName = $this->formData->firstName;
            $contact->getMiddleName = $this->formData->middleName;
            $contact->getLastName = $this->formData->lastName;
            $contact->getJobtitle = $this->formData->jobTitle;
            $contact->getDirectPhone = $this->formData->directPhone;
            $contact->getMobilePhone = $this->formData->mobilePhone;
            $contact->getEmail = $this->formData->email;
            $contact->getWebsite = $this->formData->website;
            $contact->getChartColor = $this->formData->chartColor;
        }

        $projectcontact->addJobRole($jobrole);

        $this->entityResult = array(
            'jobrole' => $jobrole,
            'contact' => $contact,
            'projectcontact' => $projectcontact,
        );
    }

    public function GetEntityResult()
    {
        return $this->entityResult;
    }
}
