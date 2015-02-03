<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Division
 * @ORM\Entity
 * @ORM\Table(name="division", indexes=
        {
          @ORM\Index(name="name_idx", columns={"name"})
        }
      )
 */
class Division extends \Application\GlobalBundle\Entity\BaseDivision
{
    /**
     * @ORM\OneToMany(targetEntity="StoreInformation", mappedBy="division")
     */
    private $store;
    public function addStore(\LimeTrail\Bundle\Entity\StoreInformation $store)
    {
        $this->store[] = $store;

        return $this;
    }

    public function __construct()
    {
        $this->store = new ArrayCollection();
    }

    /**
     * Remove stores
     *
     * @param \LimeTrail\Bundle\Entity\StoreInformation $stores
     */
    public function removeStore(\LimeTrail\Bundle\Entity\StoreInformation $store)
    {
        $this->store->removeElement($store);
    }

    /**
     * Get stores
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * Set store
     *
     * @param  \LimeTrail\Bundle\Entity\StoreInformation $store
     * @return Division
     */
    public function setStore(\LimeTrail\Bundle\Entity\StoreInformation $store = null)
    {
        $this->store = $store;

        return $this;
    }
}
