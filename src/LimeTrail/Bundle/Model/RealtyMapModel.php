<?php

namespace LimeTrail\Bundle\Model;

class RealtyMapModel
{
    /**
     * The taskMap only returns the base portion of the task.
     * You need to append Prj or Act to get the actual field.
     * Prj = projected
     * Act = actual
     */
    protected $taskMap = array(
        'Real Estate Trip' => 'ret',
        'Phase I Environmental Study' => 'phaseI',
        'Phase II Environmental Study' => 'PhaseII',
        'archRecPkg',
        
        'Real Estate Committee (REC)' => 'rec',
        'leaseExecute',
         
        'Land Under Contract:PA/Lease Signing' => 'landUc',
        'Design Review Board (DRC/DRB)' => 'drcDrb',
        'DOT/Other Entitlements' => '',
        'Planning Commission' => 'pAndZ',
        'Council Meeting (City/County)' => 'cityCouncil',
        'Entitlements Complete' => 'entitle',
        'Design Civil Package' => 'desCivil',
        'AROR/CIV Walk-around Call' => 'cwa',
        'PWO ID (Production ID Plan)' => 'pwoId',
        'Internal Closing' => 'intClosing',
        'Production Work Order (PWO)' => 'pwo',
        'Architectural Drawings Complete/OTP' => 'otp',
        'Architectural Permits Complete' => 'archPermit',
        'Civil Permits Complete' => 'civilPermit',
        'OTB Review' => 'otbReview',
        'OTB/Release Bid Package' => 'otb',
        'Bid Date' => 'bidDate',
        'Bid Award' => 'award',
        'Construction Start' => 'constrStart',
        'Possession' => 'poss',
        'Grand Open/Ceremony' => 'go',
        'otbPossDays',
        'bldgPermit',
        'closing',
        'preBidMtg',
        'devConstCompl',
        'devConstStart',
        'devPad',
        'rentCommence',
        'Warranty Period End/Project Complete' => 'warrantyCompl',
        'Topo/ALTA Survey' => '',
        'Geotechnical Report' => '',
        'Water Flow Test/Report' => '',
        'Wetlands/Natural Resource Investigation' => '',
        'Traffic Study (TIS/TIA)' => '',
        'Community Impact Study' => '',
        'Site Rezoning Process' => 'siteRezone',
        'Staff Review Approval' => '',
        'Right-of-Way Agreements' => '',
        'Entitlement Appeals/Litigation' => 'rezoneAppeal',
        'Architectural Manager Scope Trip' => '',
        'Design Civil Review' => '',
        'Civil Plans Out to Permit' => 'finalCivils',
        'DOT Permit(s) Complete' => '',
        'Food Tenant Building Permit' => '',
        'COE Impact Letter/Permit' => '',
        'Site Water Permit' => '',
        'Site Wastewater Permit' => '',
        'Contract Complete' => '',
        'COG/EOM Completion' => '',
    );
    
    /**
     * returns the base field name or null
     */
    public function getBaseFieldName($quickbaseName)
    {
        if (true === array_key_exists($quickbaseName, $this->taskMap)) {
            $taskName = $this->taskMap[$quickbaseName];
            if ( $taskName === '') {
                return null;
            }
            return $taskName;
        }
        
        return null;
    }

}
