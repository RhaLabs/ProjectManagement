<?php

namespace Application\GlobalBundle\Entity;

use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

/**
 * Zip
 * @ORM\MappedSuperclass
 */
class BaseZip
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\NotNull()
     * @Assert\Length(min = 5)
     */
    protected $zipcode;

    /**
     * Set zipcode
     * @param  integer $zipcode
     * @return Zip
     */
    public function setZipcode($zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    /**
     * Get zipcode
     * @return integer
     */
    public function getZipcode()
    {
        return $this->zipcode;
    }
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    public function __construct()
    {
    }
}
