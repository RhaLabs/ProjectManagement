<?php

namespace LimeTrail\Bundle\Form\Data;

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
