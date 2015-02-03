<?php

namespace LimeTrail\Bundle\Event;

use Doctrine\ORM\EntityNotFoundException;
use LimeTrail\Bundle\Entity\Dates;
use LimeTrail\Bundle\Entity\ProjectInformation;
use LimeTrail\Bundle\Builders\ProjectDatesBuilder;
use Symfony\Component\DependencyInjection\ContainerAware;
use Thrace\DataGridBundle\Event\RowEvent;

class ProjectDatesRowListener extends ContainerAware
{
    public function onRowAdd(RowEvent $event)
    {
        if ($event->getName() != ProjectDatesBuilder::IDENTIFIER) {
            return;
        }
        $dates = new Dates();
        $project = new ProjectInformation();

        $dates->setRundate($this->container->get('request')->request->get('rundate'));

        $dates->setStrNum($this->container->get('request')->request->get('strNum'));

        $dates->setStrSeq($this->container->get('request')->request->get('strSeq'));

        $dates->setPrjName($this->container->get('request')->request->get('prjName'));

        $dates->setCity($this->container->get('request')->request->get('city'));

        $dates->setAddress($this->container->get('request')->request->get('address'));

        $dates->setSt($this->container->get('request')->request->get('st'));

        $dates->setZip($this->container->get('request')->request->get('zip'));

        $dates->setLocation($this->container->get('request')->request->get('location'));

        $dates->setIntersection($this->container->get('request')->request->get('intersection'));

        $dates->setLat($this->container->get('request')->request->get('lat'));

        $dates->setLong($this->container->get('request')->request->get('long'));

        $dates->setGbu($this->container->get('request')->request->get('gbu'));

        $dates->setGbuDiv($this->container->get('request')->request->get('gbuDiv'));

        $dates->setStrTyp($this->container->get('request')->request->get('strTyp'));

        $dates->setPrjTyp($this->container->get('request')->request->get('prjTyp'));

        $dates->setDevTyp($this->container->get('request')->request->get('devTyp'));

        $dates->setProto($this->container->get('request')->request->get('proto'));

        $dates->setSap($this->container->get('request')->request->get('sap'));

        $dates->setProgYrPrj($this->container->get('request')->request->get('progYrPrj'));

        $dates->setProgYrAct($this->container->get('request')->request->get('progYrAct'));

        $dates->setRetPrj($this->container->get('request')->request->get('retPrj'));

        $dates->setRetAct($this->container->get('request')->request->get('retAct'));

        $dates->setPhaseIAct($this->container->get('request')->request->get('phaseIAct'));

        $dates->setPhaseIiAct($this->container->get('request')->request->get('phaseIiAct'));

        $dates->setArchRecPkgPrj($this->container->get('request')->request->get('archRecPkgPrj'));

        $dates->setArchRecPkgAct($this->container->get('request')->request->get('archRecPkgAct'));

        $dates->setRecPrj($this->container->get('request')->request->get('recPrj'));

        $dates->setRecAct($this->container->get('request')->request->get('recAct'));

        $dates->setLeaseExecutePrj($this->container->get('request')->request->get('leaseExecutePrj'));

        $dates->setLeaseExecuteAct($this->container->get('request')->request->get('leaseExecuteAct'));

        $dates->setLandUcPrj($this->container->get('request')->request->get('landUcPrj'));

        $dates->setLandUcAct($this->container->get('request')->request->get('landUcAct'));

        $dates->setDrcDrbPrj($this->container->get('request')->request->get('drcDrbPrj'));

        $dates->setDrcDrbAct($this->container->get('request')->request->get('drcDrbAct'));

        $dates->setPAndZPrj($this->container->get('request')->request->get('pAndZPrj'));

        $dates->setPAndZAct($this->container->get('request')->request->get('pAndZAct'));

        $dates->setCityCouncilPrj($this->container->get('request')->request->get('cityCouncilPrj'));

        $dates->setCityCouncilAct($this->container->get('request')->request->get('cityCouncilAct'));

        $dates->setEntitlePrj($this->container->get('request')->request->get('entitlePrj'));

        $dates->setEntitleAct($this->container->get('request')->request->get('entitleAct'));

        $dates->setDesCivilPrj($this->container->get('request')->request->get('desCivilPrj'));

        $dates->setDesCivilAct($this->container->get('request')->request->get('desCivilAct'));

        $dates->setCwaPrj($this->container->get('request')->request->get('cwaPrj'));

        $dates->setCwaAct($this->container->get('request')->request->get('cwaAct'));

        $dates->setPwoIdPrj($this->container->get('request')->request->get('pwoIdPrj'));

        $dates->setPwoIdAct($this->container->get('request')->request->get('pwoIdAct'));

        $dates->setIntClosingPrj($this->container->get('request')->request->get('intClosingPrj'));

        $dates->setIntClosingAct($this->container->get('request')->request->get('intClosingAct'));

        $dates->setPwoPrj($this->container->get('request')->request->get('pwoPrj'));

        $dates->setPwoAct($this->container->get('request')->request->get('pwoAct'));

        $dates->setOtpPrj($this->container->get('request')->request->get('otpPrj'));

        $dates->setOtpAct($this->container->get('request')->request->get('otpAct'));

        $dates->setArchPermitPrj($this->container->get('request')->request->get('archPermitPrj'));

        $dates->setArchPermitAct($this->container->get('request')->request->get('archPermitAct'));

        $dates->setCivilPermitPrj($this->container->get('request')->request->get('civilPermitPrj'));

        $dates->setCivilPermitAct($this->container->get('request')->request->get('civilPermitAct'));

        $dates->setOtbReviewPrj($this->container->get('request')->request->get('otbReviewPrj'));

        $dates->setOtbReviewAct($this->container->get('request')->request->get('otbReviewAct'));

        $dates->setOtbPrj($this->container->get('request')->request->get('otbPrj'));

        $dates->setOtbAct($this->container->get('request')->request->get('otbAct'));

        $dates->setBidDatePrj($this->container->get('request')->request->get('bidDatePrj'));

        $dates->setBidDateAct($this->container->get('request')->request->get('bidDateAct'));

        $dates->setAwardPrj($this->container->get('request')->request->get('awardPrj'));

        $dates->setAwardAct($this->container->get('request')->request->get('awardAct'));

        $dates->setConstrStartPrj($this->container->get('request')->request->get('constrStartPrj'));

        $dates->setConstrStartAct($this->container->get('request')->request->get('constrStartAct'));

        $dates->setPossPrj($this->container->get('request')->request->get('possPrj'));

        $dates->setPossAct($this->container->get('request')->request->get('possAct'));

        $dates->setGoPrj($this->container->get('request')->request->get('goPrj'));

        $dates->setGoAct($this->container->get('request')->request->get('goAct'));

        $dates->setOtbPossDays($this->container->get('request')->request->get('otbPossDays'));
    /*
     $dates->setCecContact($this->container->get('request')->request->get('cecContact'));

     $dates->setCec($this->container->get('request')->request->get('cec'));

     $dates->setCecAddress($this->container->get('request')->request->get('cecAddress'));

     $dates->setCecSuite($this->container->get('request')->request->get('cecSuite'));

     $dates->setCecCity($this->container->get('request')->request->get('cecCity'));

     $dates->setCecSt($this->container->get('request')->request->get('cecSt'));

     $dates->setCecZip($this->container->get('request')->request->get('cecZip'));

     $dates->setCecPhone($this->container->get('request')->request->get('cecPhone'));

     $dates->setCtf($this->container->get('request')->request->get('ctf'));

     $dates->setCtfPhone($this->container->get('request')->request->get('ctfPhone'));

     $dates->setGcContact($this->container->get('request')->request->get('gcContact'));

     $dates->setGc($this->container->get('request')->request->get('gc'));

     $dates->setGcPhone($this->container->get('request')->request->get('gcPhone'));

     $dates->setGcEmail($this->container->get('request')->request->get('gcEmail'));

     $dates->setGcSuper($this->container->get('request')->request->get('gcSuper'));

     $dates->setRem($this->container->get('request')->request->get('rem'));

     $dates->setRevp($this->container->get('request')->request->get('revp'));

     $dates->setCem($this->container->get('request')->request->get('cem'));

     $dates->setSaam($this->container->get('request')->request->get('saam'));

     $dates->setEst($this->container->get('request')->request->get('est'));

     $dates->setDpm($this->container->get('request')->request->get('dpm'));

     $dates->setDd($this->container->get('request')->request->get('dd'));

     $dates->setSdd($this->container->get('request')->request->get('sdd'));

     $dates->setCm($this->container->get('request')->request->get('cm'));

     $dates->setCd($this->container->get('request')->request->get('cd'));

     $dates->setMcm($this->container->get('request')->request->get('mcm'));

     $dates->setMd($this->container->get('request')->request->get('md'));

     $dates->setScd($this->container->get('request')->request->get('scd'));

     $dates->setSmd($this->container->get('request')->request->get('smd'));

     $dates->setAorComm($this->container->get('request')->request->get('aorComm'));

     $dates->setCloseoutComm($this->container->get('request')->request->get('closeoutComm'));

     $dates->setPodComm($this->container->get('request')->request->get('podComm'));

     $dates->setProbDrop($this->container->get('request')->request->get('probDrop'));

     $dates->setProbQtrMove($this->container->get('request')->request->get('probQtrMove'));

     $dates->setProbYrMove($this->container->get('request')->request->get('probYrMove'));

     $dates->setProjPhase($this->container->get('request')->request->get('projPhase'));

     $dates->setProjStatus($this->container->get('request')->request->get('projStatus'));

     $dates->setWmAtty($this->container->get('request')->request->get('wmAtty'));

     $dates->setLandUseAtty($this->container->get('request')->request->get('landUseAtty'));

     $dates->setTransAtty($this->container->get('request')->request->get('transAtty'));

     $dates->setAutoAreaPrj($this->container->get('request')->request->get('autoAreaPrj'));

     $dates->setBldgPermitAct($this->container->get('request')->request->get('bldgPermitAct'));

     $dates->setBldgPermitPrj($this->container->get('request')->request->get('bldgPermitPrj'));

     $dates->setCecComm($this->container->get('request')->request->get('cecComm'));

     $dates->setCOfOComm($this->container->get('request')->request->get('cOfOComm'));

     $dates->setClosingAct($this->container->get('request')->request->get('closingAct'));

     $dates->setClosingPrj($this->container->get('request')->request->get('closingPrj'));

     $dates->setPreBidMtg($this->container->get('request')->request->get('preBidMtg'));

     $dates->setConfidential($this->container->get('request')->request->get('confidential'));

     $dates->setFinalCOfO($this->container->get('request')->request->get('finalCOfO'));

     $dates->setDevConstComplAct($this->container->get('request')->request->get('devConstComplAct'));

     $dates->setDevConstComplPrj($this->container->get('request')->request->get('devConstComplPrj'));

     $dates->setDevConstStartAct($this->container->get('request')->request->get('devConstStartAct'));

     $dates->setDevConstStartPrj($this->container->get('request')->request->get('devConstStartPrj'));

     $dates->setDevContact($this->container->get('request')->request->get('devContact'));

     $dates->setDevContactPhone($this->container->get('request')->request->get('devContactPhone'));

     $dates->setDev($this->container->get('request')->request->get('dev'));

     $dates->setDevPadAct($this->container->get('request')->request->get('devPadAct'));

     $dates->setDevPadPrj($this->container->get('request')->request->get('devPadPrj'));

     $dates->setDriveThruPharm($this->container->get('request')->request->get('driveThruPharm'));

     $dates->setFinalCivilsAct($this->container->get('request')->request->get('finalCivilsAct'));

     $dates->setFinalCivilsPrj($this->container->get('request')->request->get('finalCivilsPrj'));

     $dates->setGardenCtrRacks($this->container->get('request')->request->get('gardenCtrRacks'));

     $dates->setGardenCtrSize($this->container->get('request')->request->get('gardenCtrSize'));

     $dates->setGardenCtrSf($this->container->get('request')->request->get('gardenCtrSf'));

     $dates->setGasStationApproval($this->container->get('request')->request->get('gasStationApproval'));

     $dates->setLedParkingLights($this->container->get('request')->request->get('ledParkingLights'));

     $dates->setLiquor($this->container->get('request')->request->get('liquor'));

     $dates->setCartCorralsReqd($this->container->get('request')->request->get('cartCorralsReqd'));

     $dates->setPharmAppr($this->container->get('request')->request->get('pharmAppr'));

     $dates->setPharmSize($this->container->get('request')->request->get('pharmSize'));

     $dates->setProtoClass($this->container->get('request')->request->get('protoClass'));

     $dates->setProtoMallEntry($this->container->get('request')->request->get('protoMallEntry'));

     $dates->setDockProto($this->container->get('request')->request->get('dockProto'));

     $dates->setEntranceProto($this->container->get('request')->request->get('entranceProto'));

     $dates->setGardenCtrProto($this->container->get('request')->request->get('gardenCtrProto'));

     $dates->setTleProto($this->container->get('request')->request->get('tleProto'));

     $dates->setProtoSize($this->container->get('request')->request->get('protoSize'));

     $dates->setRentCommenceAct($this->container->get('request')->request->get('rentCommenceAct'));

     $dates->setRentCommencePrj($this->container->get('request')->request->get('rentCommencePrj'));

     $dates->setRezoneAppealAct($this->container->get('request')->request->get('rezoneAppealAct'));

     $dates->setRezoneAppealPrj($this->container->get('request')->request->get('rezoneAppealPrj'));

     $dates->setSeasonalSf($this->container->get('request')->request->get('seasonalSf'));

     $dates->setShoppingCtrName($this->container->get('request')->request->get('shoppingCtrName'));

     $dates->setShoppingCtrType($this->container->get('request')->request->get('shoppingCtrType'));

     $dates->setSiteRezoneAct($this->container->get('request')->request->get('siteRezoneAct'));

     $dates->setSiteRezonePrj($this->container->get('request')->request->get('siteRezonePrj'));

     $dates->setTleAppr($this->container->get('request')->request->get('tleAppr'));

     $dates->setWarrantyComplAct($this->container->get('request')->request->get('warrantyComplAct'));

     $dates->setWarrantyComplPrj($this->container->get('request')->request->get('warrantyComplPrj'));
    */
     $project->addDate($dates);
        $this->process($project, $event);
    }

    public function onRowEdit(RowEvent $event)
    {
        if ($event->getName() != ProjectDatesBuilder::IDENTIFIER) {
            return;
        }
        $repo = $this->container->get('doctrine.orm.limetrail_entity_manger')->getRepository('LimeTrailBundle:ProjectInformation');
        $project = $repo->findOneById($event->getId());

        if (!$project) {
            throw new EntityNotFoundException();
        }
        $date = $project->getDates();
        foreach ($this->container->get('request')->request->all() as $req) {
            $date->set($req[])->$this->container->get('request')->request->get($req);
        }
        $project->addDate($date);
        $this->process($project, $event);
    }

    public function onRowDelete(RowEvent $event)
    {
        if ($event->getName() != ProjectDatesBuilder::IDENTIFIER) {
            return;
        }
        $repo = $this->container->get('doctrine.orm.limetrail_entity_manager')->getRepository('LimeTrailBundle:Projectinformation');
        $project = $repo->findOneById($event->getId());

        if (!$project) {
            throw new EntityNotFoundException();
        }
        $this->container->get('doctrine.orm.limetrail_entity_manager')->remove($project);
        $this->container->get('doctrine.orm.limetrail_entity_manager')->flush;
        $event->setSuccess(true);
    }

    protected function process(ProjectInformation $project, RowEvent $event)
    {
        $errors = $this->container->get('validator')->validate($project, array('default'));

        if ($errors->count() > 0) {
            $event->setErrors($this->errorsToArray($errors));
            $event->setSuccess(false);
        } else {
            $this->container->get('doctrine.orm.limetrail_entity_manager')->persist($project);
            $this->container->get('doctrin.orm.limetrail_entity_manager')->flush();
            $event->setSuccess(true);
        }
    }

    protected function errorsToArray($errors)
    {
        $data = array();
        foreach ($errors as $error) {
            $data[] = $error->getMessage();
        }

        return $data;
    }
}
