<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Address
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\Address")
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
    public function addStore(\Rha\ProjectManagementBundle\Entity\StoreInformation $store)
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
     * @return Address
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
     * Set store
     *
     * @param  \Rha\ProjectManagementBundle\Entity\StoreInformation $store
     * @return Address
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
     * @return Address
     */
    public function addCompanies(\Rha\ProjectManagementBundle\Entity\Company $companies)
    {
        $this->companies[] = $companies;

        return $this;
    }

    /**
     * Remove companies
     *
     * @param \Rha\ProjectManagementBundle\Entity\Company $companies
     */
    public function removeCompanies(\Rha\ProjectManagementBundle\Entity\Company $companies)
    {
        $this->companies->removeElement($companies);
    }
}
