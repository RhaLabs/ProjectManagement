<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * County
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\CountyRepository")
 * @ORM\Table(name="county", indexes=
 {
 @ORM\Index(name="idx", columns={"name"})
 }
 )
 */
class County extends \Application\GlobalBundle\Entity\BaseCounty
{
    /**
     * @ORM\OneToMany(targetEntity="StoreInformation", mappedBy="county")
     */
    private $store;
    public function addStore(\LimeTrail\Bundle\Entity\StoreInformation $store)
    {
        $this->store[] = $store;

        return $this;
    }

    /**
     * * @ORM\ManyToMany(targetEntity="State", mappedBy="counties")
     */
    private $state;

    /**
     * @var integer
     * @ORM\ManyToMany(targetEntity="City", mappedBy="counties")
     */
    private $cities;
    public function addcity(\LimeTrail\Bundle\Entity\City $c)
    {
        $this->cities[] = $c;

        return $this;
    }

    public function __construct()
    {
        $this->state = new ArrayCollection();
        $this->cities = new ArrayCollection();
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
     * @return County
     */
    public function setStore(\LimeTrail\Bundle\Entity\StoreInformation $store = null)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Add state
     *
     * @param  \LimeTrail\Bundle\Entity\State $state
     * @return County
     */
    public function addState(\LimeTrail\Bundle\Entity\State $state)
    {
        $this->state[] = $state;

        return $this;
    }

    /**
     * Remove state
     *
     * @param \LimeTrail\Bundle\Entity\State $state
     */
    public function removeState(\LimeTrail\Bundle\Entity\State $state)
    {
        $this->state->removeElement($state);
    }

    /**
     * Get state
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Remove cities
     *
     * @param \LimeTrail\Bundle\Entity\City $cities
     */
    public function removeCity(\LimeTrail\Bundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }

    /**
     * Get cities
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPlural()
    {
        return $this->getCities();
    }
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Add cities
     *
     * @param  \LimeTrail\Bundle\Entity\City $cities
     * @return County
     */
    public function addCitie(\LimeTrail\Bundle\Entity\City $cities)
    {
        $this->cities[] = $cities;

        return $this;
    }

    /**
     * Remove cities
     *
     * @param \LimeTrail\Bundle\Entity\City $cities
     */
    public function removeCitie(\LimeTrail\Bundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }
}
