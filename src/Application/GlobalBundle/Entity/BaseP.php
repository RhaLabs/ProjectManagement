<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * P
 * @ORM\MappedSuperclass
 * @ORM\Table(name="p")
 */
class BaseP
{
    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var string
     */
    protected $pass;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Set date
     *
     * @param  \DateTime $date
     * @return P
     */
    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    /**
     * Get date
     *
     * @return \DateTime
     */
    public function getDate()
    {
        return $this->date;
    }

    /**
     * Set pass
     *
     * @param  string $pass
     * @return P
     */
    public function setPass($pass)
    {
        $this->pass = $pass;

        return $this;
    }

    /**
     * Get pass
     *
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * Get idp
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }
}
