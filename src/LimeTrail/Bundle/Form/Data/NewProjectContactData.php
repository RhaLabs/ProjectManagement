<?php

namespace LimeTrail\Bundle\Form\Data;

use Symfony\Component\Validator\Constraints as Assert;

class NewProjectContactData
{
    public $jobRole;

    public $project;
    
    public $contact;
    
    public $projectContact;
    
    public function __construct($project)
    {
        $this->project = $project;
    }
}
