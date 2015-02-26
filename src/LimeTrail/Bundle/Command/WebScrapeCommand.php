<?php
namespace LimeTrail\Bundle\Command;

use ReflectionClass;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\NoResultException;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LimeTrail\Bundle\Command\QuickBase\QuickBaseWeb;
use LimeTrail\Bundle\Command\QuickBase\CountyWebApi;
use LimeTrail\Bundle\Entity\StoreInformation;
use LimeTrail\Bundle\Entity\ProjectInformation;
use LimeTrail\Bundle\Entity\Dates;
use LimeTrail\Bundle\Entity\Address;
use LimeTrail\Bundle\Entity\StoreType;
use LimeTrail\Bundle\Entity\StreetIntersection;
use LimeTrail\Bundle\Entity\State;
use LimeTrail\Bundle\Entity\Zip;
use LimeTrail\Bundle\Entity\ProjectType;
use LimeTrail\Bundle\Entity\City;
use LimeTrail\Bundle\Entity\Division;
use LimeTrail\Bundle\Entity\Region;
use LimeTrail\Bundle\Entity\DevelopmentType;
use LimeTrail\Bundle\Entity\DescriptionOfType;
use LimeTrail\Bundle\Entity\ProgramCategory;
use LimeTrail\Bundle\Entity\Prototype;
use LimeTrail\Bundle\Entity\ProjectStatus;
use LimeTrail\Bundle\Model\RealtyMapModel;

class WebScrapeCommand extends ContainerAwareCommand
{
    protected $em;

    protected $county;

    protected $missingPeople = array();
    
    protected $quickbase;
    
    protected $fieldMapper;
    
    protected $logger;

    private function createNewStore($entry)
    {
        $store = new StoreInformation();

        $store->setStoreNumber($entry["site_number"]);

        $dates = $this->createOrUpdateDates($entry, true, null);
      //relate the entities: making calls to custome functions which
      //try to find existing entities first failing that make new ones.
        $project = $this->createOrUpdateProject(null, $entry);
        $project->addDate($dates);

        $store
                ->addAddress($this->getAddress($entry["street_address"], $entry["latitude"], $entry["longitude"]))
                ->addStoreType($this->getNameOf("StoreType", $entry["site_type"]))
                ->addStreetIntersection($this->getNameOf("StreetIntersection", $entry["street_address"]))
                ->addState($this->getState($entry["state"]))
                ->addZip($this->getZipcode((int) $entry["postal_code"]))
                //->addCounty($this->getCountyFromCity($store->getCity()))
                ->addDivision($this->getNameOf("Division", $entry["project_alignment_bu_division_name"]))
                ->addRegion($this->getNameOf("Region", $entry["bu"]))
                ->addProject($project)
                ;
                
        $city = $entry["city"];
        if (empty($city)) {
            $city = $entry['site_city'];
        }
        
        if (!empty($city)) {
            $realCity = $this->getCityFromState($entry["city"], $store->getState());
            
            if ($realCity) {
                $store->addCity($realCity);
            }
        }

        $this->em->persist($store);
    }
  // get or update Dates
  public function createOrUpdateDates($entry, $isNew, $project)
  {
      $today = new \DateTime(date('Y-m-d'));


      try {
          if (!isset($project)) {
              throw new \Doctrine\ORM\NoResultException();
          }

          $previous = $this->getContainer()->get('lime_trail_store.provider')->findCurrentProjectDates($project->getId(), $today);

          return;
      } catch (\Doctrine\ORM\NoResultException $e) {
          $d = new Dates();

          if (isset($project)) {
              $project->setIsChanged('');
          }
          
          $tasksFromRealty = $this->getTasksFromRealty($entry);

          foreach ($tasksFromRealty as $task) {
              //look up field in the RealtyMapModel
              $fieldName = $task['task_name'];
              if ( $fieldName === '' ) {
                $fieldName = $task['task_name_other'];
              }
              
              $field = $this->fieldMapper->getBaseFieldName($fieldName);
              $this->logger->debug(sprintf("Quickbase field: %s\n", $fieldName));
              $this->logger->debug(sprintf("Rha base field: %s\n", $field));
              if (!empty($field)) {
                  $dateProjected = $this->createDateFromField($task['start_date_projected']);
                  $dateActual = $this->createDateFromField($task['start_date_actual']);
                  
                  $fieldProjected = $field."Prj";
                  $fieldActual = $field."Act";
    
                  $d = $this->setAndCompareDate($fieldProjected, $dateProjected, $project, $today, $d, $isNew);
                  $d = $this->setAndCompareDate($fieldActual, $dateActual, $project, $today, $d, $isNew);
              }
          }

          $otbdate;
          $possdate;
          if ($d->getOtbAct() == false) {
              $otbdate = $d->getOtbPrj();
          } else {
              $otbdate = $d->getOtbAct();
          }
          if ($d->getPossAct() == false) {
              $possdate = $d->getPossPrj();
          } else {
              $possdate = $d->getPossAct();
          }
          if (!empty($possdate) & !empty($otbdate)) {
              $iv = $otbdate->diff($possdate);
              $d->setOtbPossDays($iv->days);
          } else {
              $d->setOtbPossDays(0);
          }

          $d->setRundate($today);
          $this->em->persist($d);

          return $d;
      }
  }

    protected function setAndCompareDate ($field, $date, $project, $today, Dates $d, $isNew)
    {   
        $yesterday = clone $today;
        $yesterday = $this->getContainer()->get('lime_trail_store.provider')->adjustDateForWeekends($yesterday);

        $d->set($field, $date);
        
        $dateString = function($date) {
                if(!$date) {
                    return '';
                }
                return $date->format('m-d-Y');
        };
        $this->logger->debug(sprintf("Set field %s to %s\n", $field, $dateString($date)));

          //does comparison of fields
        if ($isNew === false) {
              try {
                  $previous = $this->getContainer()->get('lime_trail_store.provider')->findCurrentProjectDates($project->getId(), $yesterday);

              // gets the array of Dates objects, but there should only be one item in the array.
              $previousDates = $previous->getDates();

              // get the field from the Dates object.  useing index 0 becuase there is only one object in the array
              $oldData = $previousDates[0]->get($field);

                  if (empty($oldData)) {
                      // do nothing
                  } elseif ($oldData instanceof \DateTime and $date instanceof \DateTime) {
                      if ($oldData->format('Y-m-d') !== $date->format('Y-m-d')) {
                          $project->setIsChanged('Changed')
                          ->setDateModified(new \DateTime('NOW'));

                          $d->setDateChanged($field, true);
                      }
                  }
              } catch (\Doctrine\ORM\NoResultException $e) {
                  $project->setIsChanged('Maybe');
              }
        }
        
        return $d;
    }

    private function findInResult($array, $name)
    {
        if ($array->isEmpty()) {
            return;
        }
    /*$array->filter(
      function ($a) use ($name) {
        return in_array($array->getName(), $name);
      }
    );*/
    //$name = '%'.$name.'%';
    $criteria = Criteria::create()->where(Criteria::expr()->eq("name", $name))
                                  ->orderBy(array("name" => Criteria::ASC))
                                  ->setFirstResult(0);
        $result = $array->matching($criteria);//var_dump($result);

    return $result;
    }

  // @var if $project is null, create a new instance otherwise update. $entry is an array containing values to set
  private function createOrUpdateProject($project, $entry)
  {
      $storeProvider = $this->getContainer()->get('lime_trail_store.provider');

      if ($project) {
          $dates = $this->createOrUpdateDates($entry, false, $project);

          if (isset($dates)) {
              $project->addDate($dates);
          }

          $project->setStoreSquareFootage($entry["site_square_footage"])
                ->setIncreaseSquareFootage($entry["total_square_footage"])
                ->setPrjTotalSquareFootage($entry["site_square_footage"])
                ->setActTotalSquareFootage($entry["total_square_footage"])
                ->addProjectStatus($this->getNameOf("ProjectStatus", $entry["status"]))
                /*->setCecComm($entry["cec_comm"])
                ->setCOfOComm($entry["c_of_o_comm"])
                ->setAorComm($entry["aor_comm"])
                ->setCloseoutComm($entry["closeout_comm"])
                ->setPodComm($entry["pod_comm"])
                ->setGardenCtrRacks($entry["garden_ctr_racks"])
                ->setGardenCtrSize($entry["garden_ctr_size"])
                ->setGardenCtrSf($entry["garden_ctr_sf"])
                ->setGasStationApproval($entry["gas_station_approval"])
                ->setLedParkingLights($entry["led_parking_lights"])
                ->setCartCorralsReqd($entry["cart_corrals_reqd"])
                ->setPharmAppr($entry["pharm_appr"])
                ->setPharmSize($entry["pharm_size"])*/
                ->setProtoClass($entry["prototype_class"])
                /*->setProtoMallEntry($entry["proto_mall_entry"])
                ->setDockProto($entry["dock_proto"])
                ->setEntranceProto($entry["entrance_proto"])
                ->setGardenCtrProto($entry["garden_ctr_proto"])
                ->setTleProto($entry["tle_proto"])
                ->setProtoSize($entry["proto_size"])
                ->setShoppingCtrName($entry["shopping_ctr_name"])
                ->setShoppingCtrType($entry["shopping_ctr_type"])*/
        ;

          $this->handleProgramYear($entry, $project, $storeProvider);

          $this->relateWalmartContacts($project, $entry);

          $this->em->persist($project);

          return $project;
      } else {
          $t = new ProjectInformation();

          $t->addProjectType($this->getNameOf("ProjectType", $entry["project_type"]))
                ->setProjectPhase($entry["project_phase"])
                ->setConfidential($entry["confidential"])
                ->setCombo($entry["combo_project_name"])
                ->setManageSitesDifferent($entry["location_nickname"])
                ->setSap($entry["sap_project_definition"])
                ->setStoreSquareFootage($entry["site_square_footage"])
                ->setIncreaseSquareFootage($entry["total_square_footage"])
                ->setPrjTotalSquareFootage($entry["site_square_footage"])
                ->setActTotalSquareFootage($entry["total_square_footage"])
                ->setUser('limetrail')
                ->setLocator($entry["store.sequence"])
                ->addDevelopmentType($this->getNameOf("DevelopmentType", $entry["development_type"]))
                ->addDescriptionOfType($this->getNameOf("DescriptionOfType", $entry["description_of_subtype"]))
                ->addProgramCategory($this->getNameOf("ProgramCategory", $entry["prototype"]))
                ->addPrototype($this->getNameOf("Prototype", $entry["prototype"]))
                ->setSequence($entry["sequence_number"])
                ->addProjectStatus($this->getNameOf("ProjectStatus", $entry["status"]))
                /*->setCecComm($entry["cec_comm"])
                ->setCOfOComm($entry["c_of_o_comm"])
                ->setAorComm($entry["aor_comm"])
                ->setCloseoutComm($entry["closeout_comm"])
                ->setPodComm($entry["pod_comm"])
                ->setGardenCtrRacks($entry["garden_ctr_racks"])
                ->setGardenCtrSize($entry["garden_ctr_size"])
                ->setGardenCtrSf($entry["garden_ctr_sf"])
                ->setGasStationApproval($entry["gas_station_approval"])
                ->setLedParkingLights($entry["led_parking_lights"])
                ->setCartCorralsReqd($entry["cart_corrals_reqd"])
                ->setPharmAppr($entry["pharm_appr"])
                ->setPharmSize($entry["pharm_size"])*/
                ->setProtoClass($entry["prototype_class"])
                /*->setProtoMallEntry($entry["proto_mall_entry"])
                ->setDockProto($entry["dock_proto"])
                ->setEntranceProto($entry["entrance_proto"])
                ->setGardenCtrProto($entry["garden_ctr_proto"])
                ->setTleProto($entry["tle_proto"])
                ->setProtoSize($entry["proto_size"])
                ->setShoppingCtrName($entry["shopping_ctr_name"])
                ->setShoppingCtrType($entry["shopping_ctr_type"])*/
                ->setCanonicalName($this->ucname($entry["city"]))
                //->addContact($this->getNameOf("ProjectStatus",$entry["confidential"]))
                ->setDateCreated(new \DateTime('NOW'))//->setDateCreated(\DateTime::createFromFormat('m-d-Y h:i A', $entry["Date Created"]))
                ->setDateModified(new \DateTime('0000-00-00 00:00:00'))
                ->setIsChanged("New")
                ;

          $this->handleProgramYear($entry, $t, $storeProvider);

          $this->relateWalmartContacts($t, $entry);

          $this->em->persist($t);

          return $t;
      }
  }

    private function relateWalmartContacts($project, $entry = array())
    {
        $contactprovider = $this->getContainer()->get('lime_trail_contact.provider');

        $contacts = $contactprovider->getContactsByCompany('Walmart');

        $keys = array(
                  'Real Estate Manager/Director' => 'WM Real Estate Manager',
                  'VP - Real Estate' => 'WM Real Estate Vice President',
                  'Civil Engineering Manager' => 'WM Civil Engineering Manager',
                  'Architect Manager' => 'WM SAAM',
                  'est' => 'WM Estimator',
                  'Design Project Manager' => 'WM Design Project Manager',
                  'Design Director' => 'WM Design Director',
                  'Design Sr. Director' => 'WM Senior Design Director',
                  'Construction Manager' => 'WM Construction Manager',
                  'Construction Director' => 'WM Construction Director',
                  'Mechanical Construction Manager' => 'WM Mech Construction Manager',
                  'Mechanical Director' => 'WM Mech Director',
                  'Construction Sr. Director' => 'WM Senior Construction Director',
                  );
        try {
            $team = $this->getTeamFromRecordId($entry);
            
            foreach ($team as $member) {
                    if ($member['role'] === 'Consultant - Architect') {
                        $this->handleAorContact($member, $project);
                    }
                    
                    $contact = $contactprovider->findInResultsByName($contacts, $member['contact']);

                    if ($contact !== false) {
                        $jobrole = $contactprovider->findJobRole($keys[$member['role']]);
                        //echo "project id: {$project->getID()}\ncontact id: {$contact->getId()}\n";

                        $projectcontact = $contactprovider->findProjectContact($project, $contact);

                        if (!$projectcontact) {
                            $contactprovider->createProjectContact($project, $jobrole, $contact);
                        } else {
                            $existingProjectContacts = $contactprovider->getProjectContactsFromProjectByJobRole($project, $jobrole);

                            foreach ($existingProjectContacts as $oldProjectContact) {
                                $contactprovider->deleteProjectContact($oldProjectContact);
                            }

                            $contactprovider->updateProjectContact($projectcontact, $jobrole);
                        }
                    } else {
                        //send mail
                        $this->missingPeople[] = $member['contact'];
                    }
            }
        } catch (\Exception $e) {
        }
    }

    private function handleProgramYear($entry, $project, $storeProvider)
    {
        if (isset($project)) {
            $programYear = $project->getProgramYear();
        } else {
            $programYear = null;
        }

        $createYear = function ($year, $storeProvider) {
      if (empty($year)) {
          $year = 0;
      }

      return $storeProvider->getProgramYear($year);
    };

        $newProgramYear = $createYear((int) $entry["program_year"], $storeProvider);

        if (is_null($programYear)) {
            $project->addProgramYear($newProgramYear);
        } elseif ($programYear->getYear() != $newProgramYear->getYear()) {
            $project->setProgramYear($newProgramYear);
        } else {
            // do nothing
        }

        $this->em->persist($project);

        return true;
    }

    private function handleAorContact($entry, $project)
    {
        if (isset($project)) {
            $aorContact = $project->getAorContact();
        } else {
            $aorContact = null;
        }

        $DatesContact = $entry['contact'];

        if (empty($DatesContact) || $DatesContact == " ") {
            return;
        }

        if ($aorContact) {
            $name = $aorContact->getFirstName()." ".$aorContact->getLastName();
        } else {
            $name = null;
        }

        if ($name === $DatesContact) {
            return;
        } else {
            $contactProvider = $this->getContainer()->get('lime_trail_contact.provider');

            if (is_null($name)) {
            } else {
                //$project->removeAorContact($aorContact);
        //$aorContact->removeAorContact($project);
            }

            $nameArray = explode(" ", $DatesContact);

            $nameArray = $this->fixDatesContactName($nameArray);

            $contact = $contactProvider->getContactByShortNameAndDomain($nameArray[0], $nameArray[1], "rhaaia.com");

            $project->addAorContact($contact);

            $this->em->persist($project);
        }
    }

    private function fixDatesContactName($name)
    {
        switch ($name[0]) {
      case "Eusebo":
        $name[0] = "Eusebio (Polo)";

        $name[1] = "Padilla";

        return $name;

      default:
        return $name;
    }
    }

    private function getter($class, $property)
    {
        try {
            if ($property) {
                $t = $class->{"get$property()"};
                if (!$t) {
                    throw new NoResultException();
                }

                return $t;
            }
        } catch (\Doctrine\ORM\NoResultException $e) {
            return $t;
        }
    }
  // @var $class must be a class name. $name is the value to find
  private function getNameOf($class, $name)
  {
      $q = $this->em->getRepository("LimeTrailBundle:".$class);
      try {
          if ($name) {
              $t = $q->findOneByName($name);
              if (!$t) {
                  throw new NoResultException();
              }

              return $t;
          } else {
              return $this->createNewEntity($class, $name);
          }
      } catch (\Doctrine\ORM\NoResultException $e) {
          return $this->createNewEntity($class, $name);
      }
  }

    private function createNewEntity($class, $name)
    {
        $c = 'LimeTrail\Bundle\Entity'."\\$class";
        $t = new $c();
        $t->setName($name);
        $reflect = new ReflectionClass($t);
        if ($reflect->hasMethod('setTimestamp')) {
            $t->setTimestamp(date("Y-m-d"));
        } elseif ($reflect->hasMethod('setUser')) {
            $t->setUser('limetrail');
        }
        $this->em->persist($t);

        return $t;
    }
                // @var $class must be a class name. $name is the value to find
  private function getNumberFieldOf($class, $number)
  {
      $q = $this->em->getRepository("LimeTrailBundle:$class");
      try {
          if ($number) {
              $t = $q->findOneByNumber($number);
              if (!$t) {
                  throw new NoResultException();
              }

              return $t;
          }
      } catch (\Doctrine\ORM\NoResultException $e) {
          $c = 'LimeTrail\Bundle\Entity'."\\$class";
          $t = new $c();
          $t->setNumber($number);
          $reflect = new ReflectionClass($t);
          if ($reflect->hasMethod('setUser')) {
              $t->setUser('limetrail');
          }
          $this->em->persist($t);

          return $t;
      }
  }

        // @var $address must be a string
  private function getAddress($address, $lat, $long)
  {
      $q = $this->em->getRepository('LimeTrailBundle:Address');
      try {
          if ($address) {
              $t = $q->findOneByAddress($address);
              if (!$t) {
                  throw new NoResultException();
              }

              return $t;
          } else {
              $a = new Address();
              $a->setAddress($address)
                ->setSuite("")
                ->setLongitude($long)
                ->setLatitude($lat);
              $this->em->persist($a);

              return $a;
          }
      } catch (\Doctrine\ORM\NoResultException $e) {
          $a = new Address();
          $a->setAddress($address)
                ->setSuite("")
                ->setLongitude($long)
                ->setLatitude($lat);
          $this->em->persist($a);

          return $a;
      }
  }
      // @var $year must be a string
  private function getProgramYear($yearProjected, $yearActual)
  {
      $q = $this->em->getRepository('LimeTrailBundle:ProgramYear');
      try {
          if ($yearProjected) {
              $t = $q->findOneByProjectedYear($yearProjected);
              if (!$t) {
                  throw new NoResultException();
              }

              return $t;
          }
      } catch (\Doctrine\ORM\NoResultException $e) {
          $c = new ProgramYear();
          $c->setProjectedYear($yearProjected)->setActualYear($yearActual)->setUser('limetrail');
          $this->em->persist($c);

          return $c;
      }
  }

    private function getCountyFromCity($qcity)
    {
        if (!$qcity) {
            return;
        }

        $county = $qcity->getCounties();
        if (!$county || $county->isEmpty()) {
            return;
        }
        $c = $county->first();

        return $c;
    }

    private function getCityFromState($qcity, $state)
    {
        if (!$qcity) {
            return;
        }

        $city = $this->ucname(html_entity_decode(preg_replace('/[^\x2D\x41-\x7A\s]*(\x2C.*|\(.*)/ui', '', $qcity), ENT_NOQUOTES, 'UTF-8'));
        
        $stateName = $state->getName();
        $this->logger->notice(sprintf("Trying to find city %s in state of %s\n", $city, $stateName));
        
        $city = preg_replace('/^(st\x{2E}{0,1}\b)/iu', 'Saint', $city);
        $city = preg_replace('/^(ft.?\x{2E}{0,1}\b)/iu', 'Fort', $city);
    //HACK around messed up Dates city
    if (preg_match('/\b(Bakersfield)\b/i', $qcity, $matches) > 0) {
        $city = $matches[0];
    }
        if (preg_match('/\b(desoto)\b/i', $qcity, $matches) > 0) {
            $city = 'DeSoto';
        }
        if (preg_match('/\b(Ft. Worth)\b/i', $qcity, $matches) > 0) {
            $city = 'Fort Worth';
        }
        if (preg_match('/\b(Fort Worth)\b/i', $qcity, $matches) > 0) {
            $city = $matches[0];
        }
        if (preg_match('/\b(Lee Summit)\b/i', $qcity, $matches) > 0) {
            $city = 'Lees Summit';
        }
        if (preg_match('/\b(Memphis)\b/i', $qcity, $matches) > 0) {
            $city = $matches[0];
        }
        if (preg_match('/\b(Carmel Mountain)\b/i', $qcity, $matches) > 0) {
            $city = 'Carmel Mountain Ranch';
        }
        if ($state->getName() === 'Texas') {
            if (preg_match('/\b(DeKalb)\b/i', $qcity, $matches) > 0) {
                $city = 'De Kalb';
            } elseif (preg_match('/\b(Red Water)\b/i', $qcity, $matches) > 0) {
                $city = 'Redwater';
            }
        }
        if ($state->getName() === 'Florida') {
            if (preg_match('/\b(Lake Nona)\b/i', $qcity, $matches) > 0) {
                $city = 'Orlando';
            } elseif (preg_match('/\b(Miami Dade County)\b/i', $qcity, $matches) > 0) {
                $city = 'Princeton';
            }
        }

        $cities = $state->getCities();
        $thisCity = $this->findInResult($cities, trim(preg_replace('/\x{00a0}/siu', '', $city)));
        if (!$thisCity || $thisCity->isEmpty()) {
            return;
        }
        $c = $thisCity->first();

        return $c;
    }

    public function ucname($string)
    {
        return $this->getContainer()->get('lime_trail_contact.provider')->formatNames($string);
    }

  // @var $state must be a string
  private function getState($state)
  {
      $q = $this->em->getRepository('LimeTrailBundle:State');
      try {
          if (strlen($state) == 2) {
              $t = $q->findOneByAbbreviation($state);
              if (!$t) {
                  throw new NoResultException();
              }// echo get_class($t)."\n";

       return $t;
          } else {
              $t = $q->findOneByName($state);
              if (!$t) {
                  throw new NoResultException();
              }// echo get_class($t)."\n";

       return $t;
          }
      } catch (\Doctrine\ORM\NoResultException $e) {
          // echo "null state\n";

      return;
      }
  }

    // @var $zipcode must be a string
  private function getZipcode($zipcode)
  {
      $q = $this->em->getRepository('LimeTrailBundle:Zip');
      try {
          if ($zipcode) {
              $t = $q->findOneByZipcode($zipcode);
              if (!$t) {
                  throw new NoResultException();
              }

              return $t;
          } else {
              $zip = new Zip();
              $zip->setZipcode($zipcode);
              $this->em->persist($zip);

              return $zip;
          }
      } catch (\Doctrine\ORM\NoResultException $e) {
          $zip = new Zip();
          $zip->setZipcode($zipcode);
          $this->em->persist($zip);

          return $zip;
      }
  }
  
    protected function getTasksFromRealty($entry)
    {
        /*
         * Inorder to get tasks for a particular project we need to do a GET request to
         * curl https://wmt.quickbase.com/db/bizi7bmnf
         * where the query string should look like this:
         *  a:q
         *  qid:32
         *  query:{'48'.TV.'145736'}
         *                    ^record id
         *
         */
         $format = "{'48'.TV.'%d'}";
         $query = sprintf($format, $entry['record_id']);
         $queryString = array(
             'a' => 'q',
             'qid' => '32',
             'query' => $query,
             'clist' => 'a',
             'qrppg' => '1000',
         );

         $escapedQuery = http_build_query($queryString);

         $url = "https://wmt.quickbase.com/db/bizi7bmnf?".$escapedQuery;
         $this->logger->info(sprintf("GET %s\n", $url));
         $tableHTML = $this->quickbase->GetTable($url);
         // table to get as CSV link https://wmt.quickbase.com/db/bfngn7tvg?a=q&qid=1002789&dlta=xs~
         $result = $this->quickbase->ParseHTML($tableHTML);
         
         /*$resource = fopen("tasks-$escapedQuery.txt", 'w');
         fwrite($resource, print_r($result, true));
         fclose($resource);*/
         
         return $result;   
    }
    
    protected function getTeamFromRecordId($entry)
    {
        /*
         * Inorder to get team for a particular project we need to do a GET request to
         * curl https://wmt.quickbase.com/db/bizi7bzfd
         * where the query string should look like this:
         *  a:q
         *  qid:5
         *  query:{'20'.TV.'145736'}
         *                    ^record id
         *
         */
         $format = "{'20'.TV.'%d'}";
         $query = sprintf($format, $entry['record_id']);
         $queryString = array(
             'a' => 'q',
             'qid' => '5',
             'query' => $query,
             'clist' => 'a',
             'qrppg' => '1000',
         );

         $escapedQuery = http_build_query($queryString);

         $url = "https://wmt.quickbase.com/db/bizi7bzfd?".$escapedQuery;
         $this->logger->info(sprintf("GET %s\n", $url));
         $tableHTML = $this->quickbase->GetTable($url);
         // table to get as CSV link https://wmt.quickbase.com/db/bfngn7tvg?a=q&qid=1002789&dlta=xs~
         $result = $this->quickbase->ParseHTML($tableHTML);
         
         /*$resource = fopen('contacts.txt', 'w');
         fwrite($resource, print_r($result, true));
         fclose($resource);*/
         
         return $result;   
    }
    
    protected function createDateFromField ($field)
    {
      //tests if the $value is a validate date string: preg_match puts matches into an array
      // with the keys "month", "day", and "year"
      if (preg_match('/(?:(?P<month>\d{1,2})-(?P<day>\d{1,2})-(?P<year>\d{4}))/', $field, $matches) === 1) {
          if (checkdate($matches["month"], $matches["day"], $matches["year"])) {
              return new \DateTime($matches["month"]."/".$matches["day"]."/".$matches["year"]);
          }
      }
    }

    protected function configure()
    {
        $this->setName('limetrail:webscrape')
         ->setDescription('QuickBase web scraper');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = 'dplummer@rhaaia.com';

        $this->county = new CountyWebApi();

        $dbhost = $this->getContainer()->getParameter('database_host');

        $dbuser = $this->getContainer()->getParameter('database_user');

        $dbpass = $this->getContainer()->getParameter('database_password');
        
        $this->logger = $this->getContainer()->get('logger');

    //quickbase web
    $this->quickbase = new QuickBaseWeb($username, null, 'wmt', $dbpass, $dbhost, $dbuser);

    // first pass - get cookies
    $result = $this->quickbase->Login();

    while (!false === stripos($result, 'Operation timed out')) {
        $this->quickbase->Login();
    }
    //second pass - log in
    $this->quickbase->Login();//'qb-'.urlencode($url).'.html'
    
    $queryString = array(
             'a' => 'q',
             'qid' => '1000110',
             'qrppg' => '10000',
         );

    $escapedQuery = http_build_query($queryString);

    $url = "https://wmt.quickbase.com/db/bizi7bmne?".$escapedQuery;
    $this->logger->info(sprintf("GET %s\n", $url));
    $tableHTML = $this->quickbase->GetTable($url);
    // table to get as CSV link https://wmt.quickbase.com/db/bfngn7tvg?a=q&qid=1002789&dlta=xs~
    $result = $this->quickbase->ParseHTML($tableHTML);
    
    $this->fieldMapper = new RealtyMapModel();    
    $this->ProcessData($result);

    $emailerCommand = $this->getApplication()->find('limetrail:emailer');

        $arguments = array('');
        $input = new \Symfony\Component\Console\Input\ArrayInput($arguments);

        $returnCode = $emailerCommand->run($input, $output);

        $changesCommand = $this->getApplication()->find('limetrail:scrapechanges');

        $arguments = array(
                  '',
                  '--user' => $this->getContainer()->getParameter('qb_user'),
                  '--login-pass' => $this->getContainer()->getParameter('qb_pass'),
                 );
        $input = new \Symfony\Component\Console\Input\ArrayInput($arguments);

        $returnCode = $changesCommand->run($input, $output);

        $tenantCommand = $this->getApplication()->find('limetrail:scrapetenants');

    // using the same input as previous
    $returnCode = $tenantCommand->run($input, $output);
    }

    private function ProcessData($result)
    {
        $storeCount = 0;

        foreach ($result as $entry) {
            $this->getContainer()->get('doctrine')->resetManager();
            $this->em = $this->getContainer()->get('doctrine')->getManager('limetrail');
            $qb = $this->em->getRepository('LimeTrailBundle:StoreInformation');
            $query = $qb->findByNumberAndSequence($entry["site_number"], $entry["sequence_number"]);
            $this->logger->info(sprintf("Processing record for %s\n", $entry["store.sequence"]));
            
            if ($query) {
                $store = $query;
                $projects = $store->getProjects();
                $this->createOrUpdateProject($projects[0], $entry);
            } else {
                $this->createNewStore($entry);
            }

            try {
                $this->em->flush();
                $this->logger->info(sprintf("Flushed %s\n", $entry['store.sequence']));
            } catch (\Symfony\Component\Debug\Exception\ContextErrorException $e) {
                echo "failed to synchronize ".$entry["site_number"]."\n";
                echo "  state ".$entry["state"]."\n";
                echo "  city ".$entry["city"]."\n";
            }
            $this->em->clear();
            gc_collect_cycles();

            ++$storeCount;
        }

        print sprintf("Entered %d stores into the database\n", $storeCount);

        //dedup the missingPeople
        $people = array();

        foreach ($this->missingPeople as $key => $value) {
            $people[$value] = true;
        }

        $people = array_keys($people);

        print "The following names were found in the Walmart Dates database but not in the RHA contact database:\n";

        reset($people);

        while (list($key, $val) = each($people)) {
            print "  $val \n";
        }
    }
}
