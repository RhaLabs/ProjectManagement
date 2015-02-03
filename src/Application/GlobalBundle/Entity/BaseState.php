<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * State
 * @ORM\MappedSuperclass
 */
class BaseState
{
    /**
     * @var string
     * @ORM\Column(type="string", length=30)
     */
    protected $name;

    /**
     * Set name
     *
     * @param  string $name
     * @return State
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
     * @var string
     * @ORM\Column(type="string", length=4)
     */
    protected $abbreviation;

    /**
     * Set abbreviation
     *
     * @param  string $abbreviation
     * @return State
     */
    public function setAbbreviation($abbreviation)
    {
        $this->abbreviation = $abbreviation;

        return $this;
    }

    /**
     * Get abbreviation
     *
     * @return string
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * @var string
     * @ORM\Column(type="string", length=100, nullable=true)
     */
    protected $url;

    /**
     * Set url
     *
     * @param  string $url
     * @return State
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
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
