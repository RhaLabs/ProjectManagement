<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoreType
 * @ORM\MappedSuperclass
 */
class BaseStoreType
{
    /**
     * @var string
     * @ORM\Column(type="string", length=80)
     */
    protected $name;

    /**
     * Set name
     *
     * @param  string    $name
     * @return StoreType
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
     * @var \DateTime
     */
    protected $timestamp;

    /**
     * @var string
     * @ORM\Column(type="string", length=40)
     */
    protected $user;

    /**
     * Set user
     *
     * @param  string    $user
     * @return StoreType
     */
    public function setUser($user)
    {
        $this->user = $user;

        return $this;
    }

    /**
     * Get user
     *
     * @return string
     */
    public function getUser()
    {
        return $this->user;
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
