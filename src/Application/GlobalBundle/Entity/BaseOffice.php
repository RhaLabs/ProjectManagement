<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Company
 * @ORM\MappedSuperclass
 */
class BaseOffice
{
    /**
     * @var string
     * @ORM\Column(type="string", length=40)
     */
    protected $mainPhone;

    /**
     * @var string
     * @ORM\Column(type="integer")
     */
    protected $fax;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function __construct()
    {
    }

    /**
     * Set mainPhone
     *
     * @param  integer $mainPhone
     * @return Company
     */
    public function setMainPhone($mainPhone)
    {
        $this->mainPhone = $mainPhone;

        return $this;
    }

    /**
     * Get mainPhone
     *
     * @return integer
     */
    public function getMainPhone()
    {
        return $this->mainPhone;
    }

    /**
     * Set fax
     *
     * @param  integer $fax
     * @return Company
     */
    public function setFax($fax)
    {
        $this->fax = $fax;

        return $this;
    }

    /**
     * Get fax
     *
     * @return integer
     */
    public function getFax()
    {
        return $this->fax;
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
}
