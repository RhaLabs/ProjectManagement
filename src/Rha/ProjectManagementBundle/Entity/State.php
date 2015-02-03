<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * State
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\StateRepository")
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
    public function addStore(\Rha\ProjectManagementBundle\Entity\StoreInformation $store)
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
    public function addCounty(\Rha\ProjectManagementBundle\Entity\County $c)
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
    public function addCity(\Rha\ProjectManagementBundle\Entity\City $c)
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
     * Add companies
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Company $companies
     * @return State
     */
    public function addCompany(\Rha\ProjectManagementBundle\Entity\Company $companies)
    {
        $this->companies[] = $companies;

        return $this;
    }

    /**
     * Remove companies
     *
     * @param \Rha\ProjectManagementBundle\Entity\Company $companies
     */
    public function removeCompany(\Rha\ProjectManagementBundle\Entity\Company $companies)
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
     * @param  \Rha\ProjectManagementBundle\Entity\StoreInformation $stores
     * @return State
     */
    public function setStores(\Rha\ProjectManagementBundle\Entity\StoreInformation $stores = null)
    {
        $this->stores = $stores;

        return $this;
    }

    /**
     * Get stores
     *
     * @return \Rha\ProjectManagementBundle\Entity\StoreInformation
     */
    public function getStores()
    {
        return $this->stores;
    }

    /**
     * Remove counties
     *
     * @param \Rha\ProjectManagementBundle\Entity\County $counties
     */
    public function removeCounty(\Rha\ProjectManagementBundle\Entity\County $counties)
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
     * @param \Rha\ProjectManagementBundle\Entity\City $cities
     */
    public function removeCity(\Rha\ProjectManagementBundle\Entity\City $cities)
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
     * @param  \Rha\ProjectManagementBundle\Entity\Company $companies
     * @return State
     */
    public function addCompanie(\Rha\ProjectManagementBundle\Entity\Company $companies)
    {
        $this->companies[] = $companies;

        return $this;
    }

    /**
     * Remove companies
     *
     * @param \Rha\ProjectManagementBundle\Entity\Company $companies
     */
    public function removeCompanie(\Rha\ProjectManagementBundle\Entity\Company $companies)
    {
        $this->companies->removeElement($companies);
    }

    /**
     * Add counties
     *
     * @param  \Rha\ProjectManagementBundle\Entity\County $counties
     * @return State
     */
    public function addCountie(\Rha\ProjectManagementBundle\Entity\County $counties)
    {
        $this->counties[] = $counties;

        return $this;
    }

    /**
     * Remove counties
     *
     * @param \Rha\ProjectManagementBundle\Entity\County $counties
     */
    public function removeCountie(\Rha\ProjectManagementBundle\Entity\County $counties)
    {
        $this->counties->removeElement($counties);
    }

    /**
     * Add cities
     *
     * @param  \Rha\ProjectManagementBundle\Entity\City $cities
     * @return State
     */
    public function addCitie(\Rha\ProjectManagementBundle\Entity\City $cities)
    {
        $this->cities[] = $cities;

        return $this;
    }

    /**
     * Remove cities
     *
     * @param \Rha\ProjectManagementBundle\Entity\City $cities
     */
    public function removeCitie(\Rha\ProjectManagementBundle\Entity\City $cities)
    {
        $this->cities->removeElement($cities);
    }
}
