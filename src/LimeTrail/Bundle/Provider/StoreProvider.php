<?php
namespace LimeTrail\Bundle\Provider;

use ReflectionClass;
use ReflectionProperty;
use Doctrine\Common\Collections\Criteria;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use LimeTrail\Bundle\Entity\StoreInformation;
use LimeTrail\Bundle\Entity\ProjectInformation;
use LimeTrail\Bundle\Entity\Address;
use LimeTrail\Bundle\Entity\StoreType;
use LimeTrail\Bundle\Entity\StreetIntersection;
use LimeTrail\Bundle\Entity\State;
use LimeTrail\Bundle\Entity\Zip;
use LimeTrail\Bundle\Entity\City;
use LimeTrail\Bundle\Entity\Division;
use LimeTrail\Bundle\Entity\Region;

class StoreProvider
{
    protected $em;

    protected $provider;

  /**
   * Construct
   *
   * @param ContainerInterface $container
   * @param array $dataGridIds
   */
   public function __construct(EntityProvider $provider, EntityManager $em)
   {
       $this->provider = $provider;
       $this->em = $em;
   }

    public function findProjectById($id)
    {
        $q = $this->em->getRepository('LimeTrailBundle:StoreInformation');

        $t = $q->findByProjectId($id);

        if (!$t) {
            return;
        }

        return $t;
    }
    
    public function findProjectChangesByProjectAndChange(\LimeTrail\Bundle\Entity\ProjectInformation $project, \LimeTrail\Bundle\Entity\ChangeInitiation $change)
    {
      $q = $this->em->getRepository('LimeTrailBundle:ProjectChangeInitiation');
      
      $t = $q->findByProjectIdAndChangeId($project->getId(), $change->getId());
      
      if (!$t) {
        return;
      }
      
      return $t;
    }

    public function adjustDateForWeekends($date)
    {
        $date->sub(new \DateInterval('P1D'));

        while ((int) $date->format('N') > 5) {
            $date->sub(new \DateInterval('P1D'));
        }

        return $date;
    }

    public function findCurrentProjectDates($id, $rundate)
    {
        $q = $this->em->getRepository('LimeTrailBundle:ProjectInformation');

        $t = $q->findProjectDatesByDate($id, $rundate);

        if (!$t) {
            return;
        }

        return $t;
    }
    
    public function findChangesByProjectId($projectId)
    {
        $q = $this->em->getRepository('LimeTrailBundle:ProjectInformation');

        $t = $q->findChangesByProjectId($projectId);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function findCurrentProjects($rundate)
    {
        $q = $this->em->getRepository('LimeTrailBundle:ProjectInformation');

        $t = $q->findProjectsByDate($rundate);

        if (!$t) {
            return;
        }

        return $t;
    }

    private function createNewStore($entry)
    {
        print "createNewStore()\n";
        $store = new StoreInformation();
        print "new store\n";
        $store->setStoreNumber($entry["str_num"]);
        print "set store number\n";

        $dates = $this->createOrUpdateDates($entry);
        print "create dates\n";
      //relate the entities: making calls to custome functions which
      //try to find existing entities first failing that make new ones.
      $project = $this->createOrUpdateProject(null, $entry);
        print "create project\n";
        $project->addDate($dates);
        print "add dates to project\n";
        print "create store\n";
        $store
                ->addAddress($this->getAddress($entry["address"], $entry["lat"], $entry["long"]))
                ->addStoreType($this->getNameOf("StoreType", $entry["str_typ"]))
                ->addStreetIntersection($this->getNameOf("StreetIntersection", $entry["intersection"]))
                ->addState($this->getState($entry["st"]))
                ->addZip($this->getZipcode((int) $entry["zip"]))
                ->addCity($this->getCityFromState($entry["city"], $store->getState()))
                //->addCounty($this->getCountyFromCity($store->getCity()))
                ->addDivision($this->getNameOf("Division", $entry["gbu_div"]))
                ->addRegion($this->getNameOf("Region", $entry["gbu"]))
                ->addProject($project)
                ;
        print "persist store\n";
        $this->em->persist($store);
    }
  // get or update trident
  public function createOrUpdateDates($entry)
  {
      print "createOrUpdateDates()\n";
      $d = new Trident();
      foreach ($entry as $key => $value) {
          //tests if the $value is a validate date string: preg_match puts matches into an array
      // with the keys "month", "day", and "year"
      if (preg_match('/(?:(?P<month>\d{1,2})-(?P<day>\d{1,2})-(?P<year>\d{4}))/', $value, $matches) === 1) {
          if (checkdate($matches["month"], $matches["day"], $matches["year"])) {
              $date = new \DateTime($matches["month"]."/".$matches["day"]."/".$matches["year"]);
          //converts the $key to match casing on the entity and then set $value
          $d->set(preg_replace_callback('/_(\w)/', function ($m) {return strtoupper($m[1]);}, $key), $date);
          }
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

      $d->setRundate(new \DateTime(date('Y-m-d')));
      $this->em->persist($d);

      return $d;
  }
    private function findInResult($array, $name)
    {
        print "findInResult()\n"." count ".count($array)."\n";
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
    
    public function findFirstResultIn($array,$field, $name)
    {
        if (!$array or empty($array)) {
            return;
        }
        
        if ( !($array instanceof ArrayCollection) and is_array($array) ) {
          $array = new ArrayCollection($array);
        }

        $criteria = Criteria::create()->where(Criteria::expr()->eq($field, $name))
                                      ->orderBy(array($field => Criteria::ASC))
                                      ->setFirstResult(0);
            $result = $array->matching($criteria);//var_dump($result);

        return $result->first();
    }
    
  // @var if $project is null, create a new instance otherwise update. $entry is an array containing values to set
  private function createOrUpdateProject($project, $entry)
  {
      print "createOrUpdateProject()\n";
      if ($project) {
          $dates = $this->createOrUpdateDates($entry);
          print "create dates\n";
          $project->addDate($dates);
          print "Added more dates to project\n";

          $reflect = new ReflectionClass($project);
          $props = $reflect->getProperties(ReflectionProperty::IS_PRIVATE | ReflectionProperty::IS_PROTECTED);
        /*foreach ($props as $prop) {
          print $prop->getName() . "\n";
        }*/
        $this->em->persist($project);

          return $project;
      } else {
          $t = new ProjectInformation();
          $t->addProjectType($this->getNameOf("ProjectType", $entry["prj_typ"]))
                ->setProjectPhase($entry["prj_typ"])
                ->setConfidential($entry["confidential"])
                ->setCombo($entry["location"])
                ->setManageSitesDifferent($entry["location"])
                ->setSap($entry["sap_#"])
                ->setStoreSquareFootage($entry["proto_size"])
                ->setIncreaseSquareFootage($entry["inc_sf_act"])
                ->setPrjTotalSquareFootage($entry["tl_str_area"])
                ->setActTotalSquareFootage($entry["tl_str_area"])
                ->setUser('limetrail')
                ->setLocator($entry["str_num"].":".$entry["str_seq"])
                ->addDevelopmentType($this->getNameOf("DevelopmentType", $entry["dev_typ"]))
                ->addDescriptionOfType($this->getNameOf("DescriptionOfType", $entry["prj_name"]))
                //->addProgramYear($this->getProgramYear($entry["prog_yr_prj"],$entry["prog_yr_act"]))
                ->addProgramCategory($this->getNameOf("ProgramCategory", $entry["proto"]))
                ->addPrototype($this->getNameOf("Prototype", $entry["proto"]))
                ->setSequence($entry["str_seq"])
                ->addProjectStatus($this->getNameOf("ProjectStatus", $entry["confidential"]))
                //->addContact($this->getNameOf("ProjectStatus",$entry["confidential"]))
                ;
          $this->em->persist($t);

          return $t;
      }
  }
    private function getter($class, $property)
    {
        print "getter()\n";
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
      print "getNameOf()\n";
      print $name."\n";
      $q = $this->em->getRepository("LimeTrailBundle:".$class);
      try {
          if ($name) {
              $t = $q->findOneByName($name);
              echo get_class($t)."\n";
              if (!$t) {
                  throw new NoResultException();
              } //echo get_class($t)."\n";

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
        print "createNewEntity()\n";
        $c = 'LimeTrail\Bundle\Entity'."\\$class";
        $t = new $c();
        $t->setName($name);
        echo get_class($t)."\n";
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
      print "getNumberFieldOf()\n";
      $q = $this->em->getRepository("LimeTrailBundle:$class");
      try {
          if ($number) {
              $t = $q->findOneByNumber($number);
              echo get_class($t)."\n";
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
      print "getAddress()\n";
      $q = $this->em->getRepository('LimeTrailBundle:Address');
      try {
          if ($address) {
              $t = $q->findOneByAddress($address);
              echo get_class($t)."\n";
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
  public function getProgramYear($year)
  {
      $q = $this->em->getRepository('LimeTrailBundle:ProgramYear');
      try {
          if (isset($year)) {
              $t = $q->findOneByYear($year);
              if (!$t) {
                  throw new NoResultException();
              }

              return $t;
          }
      } catch (\Doctrine\ORM\NoResultException $e) {
          $c = new \LimeTrail\Bundle\Entity\ProgramYear();
          $c->setYear($year)
        ->setUser('limetrail');
          $this->em->persist($c);

          return $c;
      }
  }

    private function getCountyFromCity($qcity)
    {
        print "getCountyFromCity()\n";
        if (!$qcity) {
            return;
        }
        print "finding county \n";
        $county = $qcity->getCounties();
        print " count ".count($county)."\n";
        if (!$county || $county->isEmpty()) {
            return;
        }
        $c = $county->first();
        print "found county ".$c->getName()."\n";

        return $c;
    }

    private function getCityFromState($qcity, $state)
    {
        print "getCityFromState($qcity, ".$state->getName().")\n";
        if (!$qcity) {
            return;
        }
        $city = $this->ucname(html_entity_decode(preg_replace('/[^\x2D\x41-\x7A\s]*(\x2C.*|\(.*)/ui', '', $qcity), ENT_NOQUOTES, 'UTF-8'));
        $city = preg_replace('/^(st\x2E{0,1}\b)/iu', 'Saint', $city);
        $city = preg_replace('/^(ft\x2E{0,1}\b)/i', 'Fort', $city);
    //HACK around messed up trident city
    if (preg_match('/\b(Bakersfield)\b/i', $qcity, $matches) > 0) {
        $city = $matches[0];
    }
        if (preg_match('/\b(desoto)\b/i', $qcity, $matches) > 0) {
            $city = 'DeSoto';
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
        if (preg_match('/\b(Miami Dade County)\b/i', $qcity, $matches) > 0) {
            $city = 'Princeton';
        }
        if (preg_match('/\b(Carmel Mountain)\b/i', $qcity, $matches) > 0) {
            $city = 'Carmel Mountain Ranch';
        }
        print "finding city ".$city."\n";
        $cities = $state->getCities();
        $thisCity = $this->findInResult($cities, trim(preg_replace('/\x{00a0}/siu', '', $city)));
        if (!$thisCity || $thisCity->isEmpty()) {
            return;
        }
        $c = $thisCity->first();
        print "found city ".$c->getName()."\n";

        return $c;
    }
    public function ucname($string)
    {
        $string = ucwords(strtolower($string));

        foreach (array('-', '\'', 'Mc') as $delimiter) {
            if (strpos($string, $delimiter) !== false) {
                $string = implode($delimiter, array_map('ucfirst', explode($delimiter, $string)));
            }
        }

        return $string;
    }
  // @var $state must be a string
  private function getState($state)
  {
      print "getState()\n";
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
      print "getZipcode()\n";
      $q = $this->em->getRepository('LimeTrailBundle:Zip');
      try {
          if ($zipcode) {
              $t = $q->findOneByZipcode($zipcode);
              echo get_class($t)."\n";
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

    private function ProcessData($result)
    {
        foreach ($result as $entry) {
            $this->getContainer()->get('doctrine')->resetEntityManager();
            $this->em = $this->getContainer()->get('doctrine')->getManager('limetrail');
            $qb = $this->em->getRepository('LimeTrailBundle:StoreInformation');
            $query = $qb->findByNumberAndSequence($entry["str_num"], $entry["str_seq"]);

            if ($query) {
                $store = $query;
                echo "found a store\n";
                $projects = $store->getProjects();
                $this->createOrUpdateProject($projects[0], $entry);
            } else {
                $this->createNewStore($entry);
            }

            try {
                $this->em->flush();
                print "flushed store\n";
            } catch (\Symfony\Component\Debug\Exception\ContextErrorException $e) {
                echo "failed to synchronize ".$entry["str_num"]."\n";
                echo "  state ".$entry["st"]."\n";
                echo "  city ".$entry["city"]."\n";
            }
            $this->em->clear();
            gc_collect_cycles();
        }
    }
}
