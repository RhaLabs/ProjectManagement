<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * State
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\StateRepository")
 * @ORM\Table(name="state", indexes=
        {
          @ORM\Index(name="name_idx", columns={"name"}),
          @ORM\Index(name="abbrev_idx", columns={"abbreviation"})
        }
      )
 */
class State extends \Application\GlobalBundle\Entity\BaseState
{
    /**
     * @ORM\OneToMany(targetEntity="StoreInformation", mappedBy="state")
     */
    private $store;
    public function addStore(\LimeTrail\Bundle\Entity\StoreInformation $store)
    {
        $this->store[] = $store;

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="Office", mappedBy="state")
     */
    private $companies;

    /**
     * @var integer
     * @ORM\ManyToMany(targetEntity="County", inversedBy="state")
     * @ORM\JoinTable(name="state_counties",
               joinColumns={@ORM\JoinColumn(name="state_id",
                    referencedColumnName="id")},
               inverseJoinColumns={@ORM\JoinColumn(name="county_id",
                    referencedColumnName="id",
                    unique=true)})
     */
    private $counties;
    public function addCounty(\LimeTrail\Bundle\Entity\County $c)
    {
        $c->addState($this);
        $this->counties[] = $c;

        return $this;
    }
    public function addCounties($counties)
    {
        foreach ($counties as $c) {
            $this->addCounty($c);
        }
    }

    /**
     * @var integer
     * @ORM\ManyToMany(targetEntity="City", inversedBy="state")
     * @ORM\JoinTable(name="state_cities",
               joinColumns={@ORM\JoinColumn(name="state_id",
                    referencedColumnName="id")},
               inverseJoinColumns={@ORM\JoinColumn(name="city_id",
                    referencedColumnName="id",
                    unique=true)})
     */
    private $cities;
    public function addCity(\LimeTrail\Bundle\Entity\City $c)
    {
        $c->addState($this);
        $this->cities[] = $c;

        return $this;
    }
    public function addCities($cities)
    {
        foreach ($cities as $c) {
            $this->addCity($c);
        }
    }

    public function __construct()
    {
        $this->companies = new ArrayCollection();
        $this->counties = new ArrayCollection();
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
     * Add companies
     *
     * @param  \LimeTrail\Bundle\Entity\Company $companies
     * @return State
     */
    public function addCompany(\LimeTrail\Bundle\Entity\Company $companies)
    {
        $this->companies[] = $companies;

        return $this;
    }

    /**
     * Remove companies
     *
     * @param \LimeTrail\Bundle\Entity\Company $companies
     */
    public function removeCompany(\LimeTrail\Bundle\Entity\Company $companies)
    {
        $this->companies->removeElement($companies);
    }

    /**
     * Get companies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    /**
     * Set stores
     *
     * @param  \LimeTrail\Bundle\Entity\StoreInformation $stores
     * @return State
     */
    public function setStores(\LimeTrail\Bundle\Entity\StoreInformation $stores = null)
    {
        $this->stores = $stores;

        return $this;
    }

    /**
     * Get stores
     *
     * @return \LimeTrail\Bundle\Entity\StoreInformation
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * Remove counties
     *
     * @param \LimeTrail\Bundle\Entity\County $counties
     */
    public function removeCounty(\LimeTrail\Bundle\Entity\County $counties)
    {
        $this->counties->removeElement($counties);
    }

    /**
     * Get counties
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCounties()
    {
        return $this->counties;
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
    public function getCities()
    {
        return $this->cities;
    }

    /**
     * Add companies
     *
     * @param  \LimeTrail\Bundle\Entity\Company $companies
     * @return State
     */
    public function addCompanie(\LimeTrail\Bundle\Entity\Company $companies)
    {
        $this->companies[] = $companies;

        return $this;
    }

    /**
     * Remove companies
     *
     * @param \LimeTrail\Bundle\Entity\Company $companies
     */
    public function removeCompanie(\LimeTrail\Bundle\Entity\Company $companies)
    {
        $this->companies->removeElement($companies);
    }

    /**
     * Add counties
     *
     * @param  \LimeTrail\Bundle\Entity\County $counties
     * @return State
     */
    public function addCountie(\LimeTrail\Bundle\Entity\County $counties)
    {
        $this->counties[] = $counties;

        return $this;
    }

    /**
     * Remove counties
     *
     * @param \LimeTrail\Bundle\Entity\County $counties
     */
    public function removeCountie(\LimeTrail\Bundle\Entity\County $counties)
    {
        $this->counties->removeElement($counties);
    }

    /**
     * Add cities
     *
     * @param  \LimeTrail\Bundle\Entity\City $cities
     * @return State
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
