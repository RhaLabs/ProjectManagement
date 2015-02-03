<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * StoreInformation
 * @ORM\MappedSuperclass
 */
class BaseCodeReview
{
    /**
     * @var integer
     * @ORM\Column(type="integer")
     */
    protected $number;

    /**
    * @ORM\Column(type="string", length=255)
    */
    protected $SiteZoning;

    /**
    * @ORM\Column(type="string", length=255)
    */
    protected $SiteReZoning;

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
}
