<?php

namespace Rha\ProjectManagementBundle\Entity;

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

    public function addStore(\Rha\ProjectManagementBundle\Entity\StoreInformation $store)
    {
        $this->store[] = $store;

        return $this;
    }

    /**
     * Remove stores
     *
     * @param \Rha\ProjectManagementBundle\Entity\StoreInformation $stores
     */
    public function removeStore(\Rha\ProjectManagementBundle\Entity\StoreInformation $store)
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
     * @param  \Rha\ProjectManagementBundle\Entity\StoreInformation $store
     * @return StoreType
     */
    public function setStore(\Rha\ProjectManagementBundle\Entity\StoreInformation $store = null)
    {
        $this->store = $store;

        return $this;
    }

    public function __construct()
    {
        $this->store = new ArrayCollection();
    }
}
