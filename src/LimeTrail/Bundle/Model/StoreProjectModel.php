<?php

namespace LimeTrail\Bundle\Model;

use LimeTrail\Bundle\Form\Data\StoreProjectData;
use LimeTrail\Bundle\Entity\StoreInformation;
use LimeTrail\Bundle\Entity\ProjectInformation;
use LimeTrail\Bundle\Provider\StoreProvider;

class StoreProjectModel
{
    protected $provider;
    
    protected $formData;
    
    protected $entityResult;
    
    public function __construct(StoreProjectData $formData, StoreProvider $provider)
    {
        $this->provider = $provider;
        
        $this->formData = $formData;
    }
    
    public function ProcessFormData()
    {
        $store = $this->provider->findStoreByNumber($this->formData->storeNumber);
        
        if (!$store) {
            $store = new StoreInformation();
            
            $store->setStoreNumber($this->formData->storeNumber)
                  ->addState($this->provider->getState($this->formData->state))
                  ->addCity(
                        $this->provider->getCityFromState($this->formData->city, $store->getState())
                    )
                  ->addStoreType($this->formData->storeType);
            
            $project = $this->CreateProject($this->formData);
        } else {
            $projects = $store->getProjects();
            
            $projectExists = false;
            
            foreach( $projects AS $project ) {
                if($this->formData->sequenceNumber == $project->getSequence()) {
                    $projectExists = true;
                }
            }
            
            if ( $projectExists ) {
                throw new \Exception("Duplicate Project");
            }
            
            $project = $this->CreateProject($this->formData);
        }
        
        $store->addProject($project);
        
        $this->entityResult = array(
            'store' => $store,
            'project' => $project,
        );
    }
    
    public function GetEntityResult()
    {
        return $this->entityResult;
    }
    
    private function CreateProject($formData)
    {
        $project= new ProjectInformation();
            
        $project->setProjectNumber($formData->projectNumber)
                ->setSequence($formData->sequenceNumber)
                ->setProjectPhase($formData->projectPhase)
                ->setConfidential($formData->confidential)
                ->setCombo($formData->combo)
                ->setManageSitesDifferent($formData->manageSitesDifferently)
                ->setSap($formData->sap)
                ->setStoreSquareFootage($formData->storeSquareFootage)
                ->setIncreaseSquareFootage($formData->increaseSquareFootage)
                ->setPrjTotalSquareFootage($formData->prjTotalSquareFootage)
                ->setActTotalSquareFootage($formData->actTotalSquareFootage)
                ->setUser($formData->user)
                ->setLocator($formData->storeNumber.":".$formData->sequenceNumber)
                ->setDateCreated(new \DateTime('NOW'))
                ->setCanonicalName($formData->canonicalName)
                ->addProjectStatus($this->provider->getNameOf("ProjectStatus", 'Active'))
                ->addProjectType($formData->projectType)
                ;
                
        return $project;
    }
}
