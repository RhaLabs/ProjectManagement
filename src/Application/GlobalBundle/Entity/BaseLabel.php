<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Label
 * @ORM\MappedSuperclass
 * @ORM\Table(name="label")
 */
class BaseLabel
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var integer
     */
    protected $id;

    /**
     * Set name
     *
     * @param  string $name
     * @return Label
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
}
