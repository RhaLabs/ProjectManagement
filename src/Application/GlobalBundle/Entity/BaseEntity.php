<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\MappedSuperclass
 */
class BaseEntity
{
    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    public function getId()
    {
        return $this->id;
    }

    /**
     * @ORM\Column(type="datetime")
     */
    protected $createDate;

    public function getCreateDate()
    {
        return $this->createDate;
    }

    public function setCreateDate($date)
    {
        $this->createDate = $date;

        return $this;
    }

    /**
     * @ORM\Column(type="string", nullable=true)
     */
    protected $slug;

    public function setSlug($slug)
    {
        $this->slug = $this->slugify($slug);
    }

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

    /**
     * @var string
     * @Assert\NotBlank()
     * @ORM\Column(type="string", length=80)
     */
    protected $name;

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function __toString()
    {
        return $this->getName();
    }
}
