<?php
namespace LimeTrail\Bundle\Provider;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\NoResultException;
use Symfony\Component\DependencyInjection\ContainerInterface;
use LimeTrail\Bundle\Entity\State;
use LimeTrail\Bundle\Entity\Zip;

class StateProvider
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

  // @var $state must be a string
  public function getState($state)
  {
      $q = $this->em->getRepository('LimeTrailBundle:State');

      if (strlen($state) == 2) {
          $t = $q->findOneByAbbreviation($state);
          if (!$t) {
              return;
          }

          return $t;
      } else {
          $t = $q->findOneByName($state);
          if (!$t) {
              return;
          }

          return $t;
      }
  }

    public function getZipcode($zipcode)
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

    public function getProvider()
    {
        return $this->provider;
    }
}
