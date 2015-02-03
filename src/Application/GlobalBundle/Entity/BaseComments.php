<?php

namespace Application\GlobalBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 * @ORM\MappedSuperclass
 */
class BaseComments
{
    /**
     * @var integer
     */
    protected $commentTypeId;

    /**
     * @var \DateTime
     */
    protected $date;

    /**
     * @var integer
     */
    protected $contactId;

    /**
     * @var string
     */
    protected $comment;

    /**
     * @var \DateTime
     */
    protected $dateModified;

    /**
     * @var integer
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * Set commentTypeId
     *
     * @param  integer  $commentTypeId
     * @return Comments
     */
    public function setCommentTypeId($commentTypeId)
    {
        $this->commentTypeId = $commentTypeId;

        return $this;
    }

    /**
     * Get commentTypeId
     *
     * @return integer
     */
    public function getCommentTypeId()
    {
        return $this->commentTypeId;
    }

    /**
     * Set date
     *
     * @param  \DateTime $date
     * @return Comments
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
     * Set contactId
     *
     * @param  integer  $contactId
     * @return Comments
     */
    public function setContactId($contactId)
    {
        $this->contactId = $contactId;

        return $this;
    }

    /**
     * Get contactId
     *
     * @return integer
     */
    public function getContactId()
    {
        return $this->contactId;
    }

    /**
     * Set comment
     *
     * @param  string   $comment
     * @return Comments
     */
    public function setComment($comment)
    {
        $this->comment = $comment;

        return $this;
    }

    /**
     * Get comment
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set dateModified
     *
     * @param  \DateTime $dateModified
     * @return Comments
     */
    public function setDateModified($dateModified)
    {
        $this->dateModified = $dateModified;

        return $this;
    }

    /**
     * Get dateModified
     *
     * @return \DateTime
     */
    public function getDateModified()
    {
        return $this->dateModified;
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
