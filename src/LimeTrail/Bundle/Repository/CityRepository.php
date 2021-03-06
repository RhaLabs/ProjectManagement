<?php

namespace LimeTrail\Bundle\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * CityRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class CityRepository extends EntityRepository
{
    public function findByStateAndName($name, $state)
    {
        return $this->getEntityManager()->createQuery(
      'SELECT c FROM LimeTrailBundle:City c
      INNER JOIN c.state s WHERE s.name = :state AND c.name = :name'
    )
    ->setParameters(array(
      'state' => $state,
      'name' => $name,
    ))
    ->getOneOrNullResult();
    }
}
