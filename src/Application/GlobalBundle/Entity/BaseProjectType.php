<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * ProjectType
 * @ORM\MappedSuperclass
 */
class BaseProjectType
{
    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=80)
     */
    protected $name;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

     /**
     */
    protected $slug;

     /**
     * Set slug. calls slugify() first.
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    public function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('#[^\\pL\d]+#u', '-', $text);
        // trim
        $text = trim($text, '-');
        // transliterate
        if (function_exists('iconv')) {
            $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);
        }
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        $text = preg_replace('#[^-\w]+#', '', $text);
        if (empty($text)) {
            return 'n-a';
        }

        return $text;
    }

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
    }

    /**
     * Set name
     *
     * @param  string      $name
     * @return ProjectType
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
