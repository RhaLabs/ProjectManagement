<?php

/**
 * This file is part of the <name> project.
 *
 * (c) <yourname> <youremail>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Application\Sonata\UserBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="user_query", indexes={@ORM\Index(name="idx", columns={"user"})})
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\CompanyRepository")
 */
class Query
{
    /**
    * @ORM\Id
    */
    protected $Id;

    /**
    * @ORM\Column(type="string", length=255) */
    protected $query;

    /**
     * @ORM\Column(type="string", length=255) */
    protected $table;

    /**
     * @ORM\ManyToOne(targetEntity="User", inversedBy="query")
     * @ORM\JoinColumn(name="user", referencedColumnName="id") */
    protected $user;

    public function __construct()
    {
    }

    public function setTable($name)
    {
        $this->table = $name;

        return $this;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getId()
    {
        return $this->Id;
    }

    public function setId($id)
    {
        $this->Id = $id;
    }

    public function getQuery()
    {
        return $this->query;
    }

    public function setQuery($query)
    {
        $this->query = $query;
    }
}
