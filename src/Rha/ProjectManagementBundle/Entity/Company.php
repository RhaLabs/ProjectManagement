<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Company
 * @ORM\Entity
 * @ORM\Table(name="company", indexes=
 {
 @ORM\Index(name="idx", columns={"name"}),
 @ORM\Index(name="category_idx", columns={"category"})
 }
 )
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\CompanyRepository")
 */
class Company
{
    /**
     * @var string
     * @ORM\Column(type="string", length=60)
     */
    private $name;

    /** @ORM\ManyToMany(targetEntity="Office", inversedBy="company")
     * @ORM\JoinTable(name="company_offices",
     joinColumns={@ORM\JoinColumn(name="company_id", referencedColumnName="id")},
     inverseJoinColumns={@ORM\JoinColumn(name="office_id", referencedColumnName="id", unique=true)}
     )
     */
    private $offices;

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Category", inversedBy="companies")
     * @ORM\JoinColumn(name="category", referencedColumnName="id")
     */
    private $category;
    public function addCategory($category)
    {
        $this->category = $category;
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    public function __construct()
    {
        $offices = new ArrayCollection();
    }

    public function getContacts()
    {
        $contacts = array();
        foreach ($this->offices as $office) {
            $contacts[] = $office->contacts;
        }

        return $contacts;
    }

    /**
     * Set name
     *
     * @param  string  $name
     * @return Company
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set category
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Category $category
     * @return Company
     */
    public function setCategory(\Rha\ProjectManagementBundle\Entity\Category $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \Rha\ProjectManagementBundle\Entity\Category
     */
    public function getCategory()
    {
        return $this->category;
    }

    public function getOffices()
    {
        return $this->offices;
    }

    public function setOffice(\Rha\ProjectManagementBundle\Entity\Office $office)
    {
        $this->offices[] = $office;

        return $this;
    }
}
