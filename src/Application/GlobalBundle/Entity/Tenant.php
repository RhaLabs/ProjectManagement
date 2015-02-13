<?php

namespace Application\GlobalBundle\Entity;

use APY\DataGridBundle\Grid\Mapping as GRID;
use Doctrine\ORM\Mapping as ORM;

/**
 * Categories
 * @ORM\MappedSuperclass
 */
class Tenant
{
    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $tenant;

    public function setTenant($tenant)
    {
        $this->tenant = $tenant;

        return $this;
    }

    public function getTenant()
    {
        return $this->tenant;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    protected $type;

    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    public function getType()
    {
        return $this->type;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=128, nullable=true)
     */
    protected $comment;

    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    public function getComment()
    {
        return $this->comment;
    }

    /**
     * @var string
     * @ORM\Column(type="datetime", nullable=true)
     *
     * @GRID\Column(field="date", title="Date", type="datetime", format="m/d/Y")
     */
    protected $date;

    public function setDate($date)
    {
        $this->date = $date;

        return $this;
    }

    public function getDate()
    {
        return $this->date;
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     *
     * @GRID\Column(field="id", visible=false)
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }
}
