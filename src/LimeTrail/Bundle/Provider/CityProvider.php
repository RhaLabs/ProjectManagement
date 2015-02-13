<?php
namespace LimeTrail\Bundle\Provider;

use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use LimeTrail\Bundle\Entity\State;
use LimeTrail\Bundle\Entity\City;

class CityProvider
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

    public function findCityById($id)
    {
        $q = $this->em->getRepository('LimeTrailBundle:City');

        $t = $q->findOneById($id);

        if (!$t) {
            return;
        }

        return $t;
    }

    public function getCountyFromCity($qcity)
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

    public function getCityFromState($qcity, $state)
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
        $thisCity = $this->provider->findInResult($cities, 'name', trim(preg_replace('/\x{00a0}/siu', '', $city)));
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

    public function getProvider()
    {
        return $this->provider;
    }
}
