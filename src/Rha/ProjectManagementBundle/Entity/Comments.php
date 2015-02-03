<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Comments
 *
 * @ORM\Table(name="comments")
 */
class Comments  extends \Application\GlobalBundle\Entity\BaseComments
{
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
}
