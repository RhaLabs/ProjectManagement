<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CodeReview
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\CodeReviewRepository")
 * @ORM\Table(name="code_review_becr")
 */
class CodeReview extends \Application\GlobalBundle\Entity\BaseCodeReview
{
    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="\Rha\ProjectManagementBundle\Entity\ProjectInformation", inversedBy="becr")
     */
    private $project;

    public function addProject($project)
    {
        $project->addBecr($this);

        $this->project = $project;

        return $this;
    }
}
