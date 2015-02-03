<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 * @ORM\Entity
 * @ORM\Table(name="categories", indexes=
          {
            @ORM\Index(name="idx", columns={"category"})
          }
        )
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\CategoryRepository")
 */
class Category extends \Application\GlobalBundle\Entity\BaseCategory
{
    /**
     * @ORM\OneToMany(targetEntity="Company", mappedBy="category")
     */
    private $companies;

    public function __construct()
    {
        $this->companies = new ArrayCollection();
    }

    /**
     * Add companies
     *
     * @param  \LimeTrail\Bundle\Entity\Company $companies
     * @return Category
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
     * Get companies
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getCompanies()
    {
        return $this->companies;
    }
}
