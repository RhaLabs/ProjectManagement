<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="architectural_details"
      )
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\ArchitecturalDetailRepository")
 */
class ArchitecturalDetail
{
    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    private $name;

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=128)
     */
    private $reference;

    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    public function getReference()
    {
        return $this->reference;
    }

    /**
     * @var string
     * @ORM\Column(type="blob")
     */
    private $thumbnail;

    public function setThumbnail($thumbnail)
    {
        $this->thumbnail = $thumbnail;

        return $this;
    }

    public function getThumbnail()
    {
        return $this->thumbnail;
    }

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

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
