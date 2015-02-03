<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ProjectContacts
 * @ORM\MappedSuperclass
 */
class BaseProjectContacts
{
    /**
     * @var string
     */
    protected $timestamp;

    /**
     * @var string
     */
    protected $user;

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
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
