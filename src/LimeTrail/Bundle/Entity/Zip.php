<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Zip
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\ZipRepository")
 * @ORM\Table(name="zip", indexes={@ORM\Index(name="idx", columns={"zipcode"})})
 */
class Zip extends \Application\GlobalBundle\Entity\BaseZip
{
    /**
     * @ORM\OneToMany(targetEntity="StoreInformation", mappedBy="zip")
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
     * @return Zip
     */
    public function setStore(\LimeTrail\Bundle\Entity\StoreInformation $store = null)
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
     * @param  \LimeTrail\Bundle\Entity\Company $companies
     * @return Zip
     */
    public function addCompanies(\LimeTrail\Bundle\Entity\Office $companies)
    {
        $this->companies[] = $companies;

        return $this;
    }

    /**
     * Remove companies
     *
     * @param \LimeTrail\Bundle\Entity\Company $companies
     */
    public function removeCompanies(\LimeTrail\Bundle\Entity\Office $companies)
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
