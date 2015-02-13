<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * City
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\CityRepository")
 * @ORM\Table(name="city", indexes=
 {
 @ORM\Index(name="idx", columns={"name"})
 }
 )
 */
class City extends \Application\GlobalBundle\Entity\BaseCity
{
    /**
     * @ORM\OneToMany(targetEntity="StoreInformation", mappedBy="city")
     */
    private $store;
    public function addStore(\Rha\ProjectManagementBundle\Entity\StoreInformation $store)
    {
        $this->store[] = $store;

        return $this;
    }

    /**
     * @ORM\OneToMany(targetEntity="Office", mappedBy="city")
     */
    private $companies;

    /**
     * * @ORM\ManyToMany(targetEntity="State", mappedBy="cities")
     */
    private $state;

    /**
     * @var integer
     * @ORM\ManyToMany(targetEntity="County", inversedBy="cities")
     * @ORM\JoinTable(name="cities_counties",
     joinColumns={@ORM\JoinColumn(name="city_id",
     referencedColumnName="id")},
     inverseJoinColumns={@ORM\JoinColumn(name="county_id",
     referencedColumnName="id")})
     */
    private $counties;
    public function addCounty(\Rha\ProjectManagementBundle\Entity\County $c)
    {
        $c->addCity($this);
        $this->counties[] = $c;

        return $this;
    }
    public function addCounties($counties)
    {
        foreach ($counties as $c) {
            $this->addCounty($c);
        }
    }

    public function __construct()
    {
        $this->companies = new ArrayCollection();
        $this->state = new ArrayCollection();
        $this->counties = new ArrayCollection();
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
     * @return City
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
     * Add state
     *
     * @param  \Rha\ProjectManagementBundle\Entity\State $state
     * @return City
     */
    public function addState(\Rha\ProjectManagementBundle\Entity\State $state)
    {
        $this->state[] = $state;

        return $this;
    }

    /**
     * Remove state
     *
     * @param \Rha\ProjectManagementBundle\Entity\State $state
     */
    public function removeState(\Rha\ProjectManagementBundle\Entity\State $state)
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
    public function getPlural()
    {
        return $this->getCounties();
    }
    public function getCounties()
    {
        return $this->counties;
    }

    /**
     * Set store
     *
     * @param  \Rha\ProjectManagementBundle\Entity\StoreInformation $store
     * @return City
     */
    public function setStore(\Rha\ProjectManagementBundle\Entity\StoreInformation $store = null)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Add companies
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Company $companies
     * @return City
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
     * @return City
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
}
