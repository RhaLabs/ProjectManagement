<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Zip
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\ZipRepository")
 * @ORM\Table(name="zip", indexes={@ORM\Index(name="idx", columns={"zipcode"})})
 */
class Zip extends \Application\GlobalBundle\Entity\BaseZip
{
    /**
     * @ORM\OneToMany(targetEntity="StoreInformation", mappedBy="zip")
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
     * @return Zip
     */
    public function setStore(\Rha\ProjectManagementBundle\Entity\StoreInformation $store = null)
    {
        $this->store = $store;

        return $this;
    }
    /**
     * @ORM\OneToMany(targetEntity="Office", mappedBy="zip")
     */
    private $companies;

    /**
     * Add companies
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Company $companies
     * @return Zip
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

    /**
     * Get companies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanies()
    {
        return $this->companies;
    }

    public function __construct()
    {
        $this->companies = new ArrayCollection();
        $this->store = new ArrayCollection();
    }
}
