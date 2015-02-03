<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Company
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\OfficeRepository")
 * @ORM\Table(name="offices", indexes=
      {
        @ORM\Index(name="phone_idx", columns={"mainPhone"})
      }
    )
 */
class Office extends \Application\GlobalBundle\Entity\BaseOffice
{
    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Address", inversedBy="companies")
     * @ORM\JoinColumn(name="address", referencedColumnName="id")
     */
    private $address;
    public function addAddress($address)
    {
        $this->address = $address;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="City", inversedBy="companies")
     * @ORM\JoinColumn(name="city", referencedColumnName="id")
     */
    private $city;
    public function addCity($city)
    {
        $this->city = $city;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="State", inversedBy="companies")
     * @ORM\JoinColumn(name="state", referencedColumnName="id")
     */
    private $state;
    public function addState($state)
    {
        $this->state = $state;
    }

    /**
     * @var integer
     * @ORM\ManyToOne(targetEntity="Zip", inversedBy="companies")
     * @ORM\JoinColumn(name="zip", referencedColumnName="id")
     */
    private $zip;
    public function addZip($zipcode)
    {
        $this->zip = $zip;
    }

    /**
     * @ORM\OneToMany(targetEntity="Contact", mappedBy="office")
     */
    private $contacts;

    /**
     * @ORM\ManyToMany(targetEntity="Company", mappedBy="offices")
     */
    private $company;

    public function __construct()
    {
        $this->contacts = new ArrayCollection();
    }

    /**
     * Set address
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Address $address
     * @return Company
     */
    public function setAddress(\Rha\ProjectManagementBundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \Rha\ProjectManagementBundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param  \Rha\ProjectManagementBundle\Entity\City $city
     * @return Company
     */
    public function setCity(\Rha\ProjectManagementBundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \Rha\ProjectManagementBundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param  \Rha\ProjectManagementBundle\Entity\State $state
     * @return Company
     */
    public function setState(\Rha\ProjectManagementBundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \Rha\ProjectManagementBundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Zip $zip
     * @return Company
     */
    public function setZip(\Rha\ProjectManagementBundle\Entity\Zip $zip = null)
    {
        $this->zip = $zip;

        return $this;
    }

    /**
     * Get zip
     *
     * @return \Rha\ProjectManagementBundle\Entity\Zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Add contacts
     *
     * @param  \Rha\ProjectManagementBundle\Entity\Contact $contacts
     * @return Company
     */
    public function addContact(\Rha\ProjectManagementBundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \Rha\ProjectManagementBundle\Entity\Contact $contacts
     */
    public function removeContact(\Rha\ProjectManagementBundle\Entity\Contact $contacts)
    {
        $this->contacts->removeElement($contacts);
    }

    /**
     * Get contacts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getContacts()
    {
        return $this->contacts;
    }

    public function getCompany()
    {
        return $this->company;
    }
}
