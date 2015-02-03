<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StreetIntersection
 * @ORM\MappedSuperclass
 */
class BaseStreetIntersection
{
    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $name;

    /**
     * Set name
     *
     * @param  string             $name
     * @return StreetIntersection
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
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Get id
     *
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
