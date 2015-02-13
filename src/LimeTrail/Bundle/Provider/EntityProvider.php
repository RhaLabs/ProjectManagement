<?php
namespace LimeTrail\Bundle\Provider;

use ReflectionClass;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use LimeTrail\Bundle\Entity\Address;

class EntityProvider
{
    protected $em;

  /**
   * @var ContainerInterface
   */
  private $container;

   /**
    * Construct
    *
    * @param ContainerInterface $container
    * @param array $dataGridIds
    */
   public function __construct(EntityManager $em)
   {
       $this->em = $em;
   }

    public function findInResult($array, $field, $value)
    {
        if ($array->isEmpty()) {
            return;
        }

        $criteria = Criteria::create()->where(Criteria::expr()->eq($field, $value))
                                  ->orderBy(array($field => Criteria::ASC))
                                  ->setFirstResult(0);
        $result = $array->matching($criteria);

        return $result;
    }

    public function getter($class, $property)
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
  public function getNameOf($class, $name)
  {
      $q = $this->em->getRepository("LimeTrailBundle:".$class);

      if ($name) {
          $t = $q->findOneByName($name);
          if (!$t) {
              return $this->createNewEntity($class, $name);
          }

          return $t;
      } else {
          return $this->createNewEntity($class, $name);
      }
  }

    public function createNewEntity($class, $name)
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
  public function getNumberFieldOf($class, $number)
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
  public function getAddress($address, $lat, $long)
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
  public function getProgramYear($yearProjected, $yearActual)
  {
      print "getProgramYear()\n";
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
}
