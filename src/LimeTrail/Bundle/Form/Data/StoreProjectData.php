<?php

namespace LimeTrail\Bundle\Form\Data;


class StoreProjectData
{
    public $storeNumber;
    public $sequenceNumber;
    public $projectNumber;
    public $projectPhase;
    public $confidential;
    public $combo;
    public $manageSitesDifferently;
    public $sap;
    public $storeSquareFootage;
    public $increaseSquareFootage;
    public $prjTotalSquareFootage;
    public $actTotalSquareFootage;
    public $user;
    public $state;
    public $city;
    public $canonicalName;
    public $storeType;
    public $projectType;
    
    public function __construct()
    {
        $this->projectPhase = 0;
        $this->confidential = false;
        $this->combo = false;
        $this->manageSitesDifferently = false;
        $this->sap = 'unknown';
        $this->storeSquareFootage = 0;
        $this->increaseSquareFootage = 0;
        $this->prjTotalSquareFootage = 0;
        $this->actTotalSquareFootage = 0;
    }
}
