<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Company
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\OfficeRepository")
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
        $zipcode->addCompanies($this);

        $this->zip = $zipcode;

        return $this;
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
     * @param  \LimeTrail\Bundle\Entity\Address $address
     * @return Company
     */
    public function setAddress(\LimeTrail\Bundle\Entity\Address $address = null)
    {
        $this->address = $address;

        return $this;
    }

    /**
     * Get address
     *
     * @return \LimeTrail\Bundle\Entity\Address
     */
    public function getAddress()
    {
        return $this->address;
    }

    /**
     * Set city
     *
     * @param  \LimeTrail\Bundle\Entity\City $city
     * @return Company
     */
    public function setCity(\LimeTrail\Bundle\Entity\City $city = null)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return \LimeTrail\Bundle\Entity\City
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set state
     *
     * @param  \LimeTrail\Bundle\Entity\State $state
     * @return Company
     */
    public function setState(\LimeTrail\Bundle\Entity\State $state = null)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get state
     *
     * @return \LimeTrail\Bundle\Entity\State
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * Set zip
     *
     * @param  \LimeTrail\Bundle\Entity\Zip $zip
     * @return Company
     */
    public function setZip($zip = null)
    {
        return $this->addZip($zip);
    }

    /**
     * Get zip
     *
     * @return \LimeTrail\Bundle\Entity\Zip
     */
    public function getZip()
    {
        return $this->zip;
    }

    /**
     * Add contacts
     *
     * @param  \LimeTrail\Bundle\Entity\Contact $contacts
     * @return Company
     */
    public function addContact(\LimeTrail\Bundle\Entity\Contact $contacts)
    {
        $this->contacts[] = $contacts;

        return $this;
    }

    /**
     * Remove contacts
     *
     * @param \LimeTrail\Bundle\Entity\Contact $contacts
     */
    public function removeContact(\LimeTrail\Bundle\Entity\Contact $contacts)
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
