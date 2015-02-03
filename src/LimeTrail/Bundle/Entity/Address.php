<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Address
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\Address")
 * @ORM\Table(name="address", indexes=
        {
          @ORM\Index(name="suite_idx", columns={"suite"}),
          @ORM\Index(name="address_idx", columns={"address"})
        }
      )
 */
class Address extends \Application\GlobalBundle\Entity\BaseAddress
{
    /**
     * @ORM\OneToMany(targetEntity="StoreInformation", mappedBy="address", cascade={"persist", "remove"})
     */
    private $store;
    public function addStore(\LimeTrail\Bundle\Entity\StoreInformation $store)
    {
        $this->store[] = $store;

        return $this;
    }
    /**
     * @ORM\OneToMany(targetEntity="Office", mappedBy="address", cascade={"persist"})
     */
    private $companies;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
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
     * @return Address
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
     * Set store
     *
     * @param  \LimeTrail\Bundle\Entity\StoreInformation $store
     * @return Address
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
     * @return Address
     */
    public function addCompanies(\LimeTrail\Bundle\Entity\Company $companies)
    {
        $this->companies[] = $companies;

        return $this;
    }

    /**
     * Remove companies
     *
     * @param \LimeTrail\Bundle\Entity\Company $companies
     */
    public function removeCompanies(\LimeTrail\Bundle\Entity\Company $companies)
    {
        $this->companies->removeElement($companies);
    }
}
