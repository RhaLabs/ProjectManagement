<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * City
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\CityRepository")
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
    public function addStore(\LimeTrail\Bundle\Entity\StoreInformation $store)
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
     * @ORM\OrderBy({"name" = "ASC"})
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
    public function addCounty(\LimeTrail\Bundle\Entity\County $c)
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
     * @return City
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
     * Add state
     *
     * @param  \LimeTrail\Bundle\Entity\State $state
     * @return City
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
     * @param  \LimeTrail\Bundle\Entity\StoreInformation $store
     * @return City
     */
    public function setStore(\LimeTrail\Bundle\Entity\StoreInformation $store = null)
    {
        $this->store = $store;

        return $this;
    }

    /**
     * Add companies
     *
     * @param  \LimeTrail\Bundle\Entity\Company $companies
     * @return City
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
     * @return City
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
}
