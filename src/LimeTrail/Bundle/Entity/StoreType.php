<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * StoreType
 * @ORM\Entity
 * @ORM\Table(name="store_type", indexes=
        {
          @ORM\Index(name="name_idx", columns={"name"})
        }
      )
 */
class StoreType extends \Application\GlobalBundle\Entity\BaseStoreType
{
    /**
     * @ORM\OneToMany(targetEntity="StoreInformation", mappedBy="storeType")
     */
    private $store;

    public function addStore(\LimeTrail\Bundle\Entity\StoreInformation $store)
    {
        $this->store[] = $store;

        return $this;
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
     * @return StoreType
     */
    public function setStore(\LimeTrail\Bundle\Entity\StoreInformation $store = null)
    {
        $this->store = $store;

        return $this;
    }

    public function __construct()
    {
        $this->store = new ArrayCollection();
    }
}
