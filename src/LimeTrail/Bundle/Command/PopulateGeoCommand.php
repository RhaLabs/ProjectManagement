<?php

namespace LimeTrail\Bundle\Command;

use Doctrine\Common\Collections\Criteria;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use LimeTrail\Bundle\Entity\City;
use LimeTrail\Bundle\Entity\County;
use LimeTrail\Bundle\Entity\State;
use LimeTrail\Bundle\Provider\StateProvider;

class PopulateGeoCommand extends ContainerAwareCommand
{
    protected $em;
    protected $stateProvider;
    protected function configure()
    {
        $this->setName('limetrail:populategeo')
         ->setDescription('fill state info');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->em = $this->getContainer()->get('doctrine')->getManager('limetrail');
        $this->stateProvider = $this->getContainer()->get('lime_trail_state.provider');
        $this->GetStateInfo($qb);
    }

    private function GetWebData($state)
    {
        /*http://www.sba.gov/about-sba/sba_performance/sba_data_store/web_service_api/u_s_city_and_county_web_data_api*/
   // URL to login page
    $url = 'http://api.sba.gov/geodata/city_county_data_for_state_of/'.urlencode($state).'.json';

        return file_get_contents($url);
    }

    public function GetStateInfo()
    {
        $states = array(
        "AL","AK", "AZ","AR","CA","CO","CT","DE","FL","GA","HI","ID","IL","IN","IA","KS","KY","LA","ME","MD","MA",
        "MI","MN","MS","MO","MT","NE","NV","NH","NJ","NM","NY","NC","ND","OH","OK","OR","PA","RI","SC","SD","TN","TX",
        "UT","VT","VA","WA","WV","WI","WY",);
        foreach ($states as $state) {
            // api.sba.gov returns an array of objects
      $obj = $this->mjson_decode($this->GetWebData($state));
      //var_dump($obj);
      if (!$obj) {
          exit("no data");
      }
            $s = $this->getState($state);
      //check for existence otherwise make a state
      if (!$s) {
          $s = new State();
          $s->setName($obj[0]->state_name);
          $s->setAbbreviation($obj[0]->state_abbreviation);
          $s->setUrl("todo");
          $this->em->persist($s);
      }

            foreach ($obj as $feature) {
                $cities = $s->getCities(); //echo count($cities)."\n";
        if (strcmp(substr($feature->fips_class, 0, 1), "C") == 0) {
            // fips classes starting with C are cities;
          // first check that the county exists or create it
          if ($cities->isEmpty()) {
              $city = $this->createfeature("City", $s, $feature);
              $feature_county = $this->findInStateFeature($obj, $feature->county_name);
              if (!is_null($feature_county)) {
                  $county = $this->createOrUpdate("County", $s, $feature_county);
                  $city->addCounty($county);
              }
          } else {
              $t = $this->findInResult($cities, $feature->name);
              if (!$t || $t->isEmpty()) {
                  $i = $this->createfeature("City", $s, $feature);
                  $feature_county = $this->findInStateFeature($obj, $feature->county_name);
                  if (!is_null($feature_county)) {
                      $county = $this->createOrUpdate("County", $s, $feature_county);
                      $i->addCounty($county);
                  } else {
                  }
              }
          }
        }/* else if (strcmp(substr($feature->fips_class,0,1),"H") == 0) {
          // those starting with H are counties
          $counties = $s->getCounties();
          if ($counties->isEmpty()) {
            // no counties if the collection is null
            $county = $this->createfeature("County", $s, $feature);
          } else {
          foreach ($counties as $county) {
            if ($county->getName() == $feature->name) {
              //do an update
            } else {
              $i = $this->createfeature("County", $s, $feature);
            }
          }
          }
        }*/
            }
            $this->em->persist($s);
            $this->em->flush();
        }
    }
  // $obj = "City" or "County"  $owner = $parent_object $feature= $feature
  protected function createOrUpdate($obj, $owner, $feature)
  {
      $name;
      $url;
      if (is_array($feature)) {
          $name = trim(preg_replace('/\d\((historical)\)/i', '', $feature["COUNTY_NAME"]));
          $url = "todo";
      } else {
          $name = $feature->name;
          $url = $feature->url;
      }
      $plural = preg_replace("/[y]/", "ies", $obj);
      $t = $this->getContainer()->get('lime_trail_state.provider')->getProvider()->findInResult($owner->{"get$plural"}(), $name);
      if (!$t || $t->isEmpty()) {
          $o = 'LimeTrail\\Bundle\\Entity'."\\$obj";
          $t = new $o();//echo "new $o\n";
      $t->setName($name)
        ->setUrl($url);//echo $t->getName()."\n";
      $owner->{"add$obj"}($t);
      } else {
          $t = $t->first();
          $t->setName($name)
        ->setUrl($url);
      }
      $this->em->persist($t);

      return $t;
  }
    protected function findInStateFeature($features, $name)
    {
        $result = null;
        foreach ($features as $feature) {
            if (strcmp(substr($feature->fips_class, 0, 2), "H1") == 0) {
                if (strcmp($feature->name, $name) == 0) {
                    $result = $feature;
                }
            }
        }

        return $result;
    }
    protected function findInResult($array, $name)
    {
        if ($array->isEmpty()) {
            return;
        }
    /*$array->filter(
      function ($a) use ($name) {
        return in_array($array->getName(), $name);
      }
    );*/
    $criteria = Criteria::create()->where(Criteria::expr()->eq("name", $name))
                                  ->orderBy(array("name" => Criteria::ASC))
                                  ->setFirstResult(0);
        $result = $array->matching($criteria);//var_dump($result);

    return $result;
    }
    protected function createfeature($obj, $owner, $feature)
    {
        $c = 'LimeTrail\Bundle\Entity'."\\$obj";
        $t = new $c();//echo "new $c\n";
    if (is_array($feature)) {
        $t->setName(trim(preg_replace('/\d\((historical)\)/i', '', $feature["FEATURE_NAME"])))
        ->setUrl("todo");//echo $t->getName()."\n";
    } else {
        $t->setName($feature->name)
       ->setUrl($feature->url);//echo $t->getName()."\n";
    }
        $owner->{"add$obj"}($t);
        $this->em->persist($t);

        return $t;
    }
    // @var $state must be a string
  protected function getState($state)
  {
      return $this->getContainer()->get('lime_trail_state.provider')->getState($state);
  }

    protected function mjson_decode($json)
    {
        return json_decode($this->removeTrailingCommas(utf8_encode($json)));
    }

    public function removeTrailingCommas($json)
    {
        $json = preg_replace('/,\s*([\]}])/m', '$1', $json);

        return $json;
    }
    public function json_last_error_msg()
    {
        static $errors = array(
            JSON_ERROR_NONE             => null,
            JSON_ERROR_DEPTH            => 'Maximum stack depth exceeded',
            JSON_ERROR_STATE_MISMATCH   => 'Underflow or the modes mismatch',
            JSON_ERROR_CTRL_CHAR        => 'Unexpected control character found',
            JSON_ERROR_SYNTAX           => 'Syntax error, malformed JSON',
            JSON_ERROR_UTF8             => 'Malformed UTF-8 characters, possibly incorrectly encoded',
        );
        $error = json_last_error();

        return array_key_exists($error, $errors) ? $errors[$error] : "Unknown error ({$error})";
    }
}
