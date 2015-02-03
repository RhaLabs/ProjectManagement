<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * CodeReview
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\CodeReviewRepository")
 * @ORM\Table(name="code_review_becr")
 */
class CodeReview extends \Application\GlobalBundle\Entity\BaseCodeReview
{
    /**
     * @var integer
     * @ORM\OneToOne(targetEntity="\LimeTrail\Bundle\Entity\ProjectInformation", inversedBy="becr")
     */
    private $project;

    public function addProject($project)
    {
        $project->addBecr($this);

        $this->project = $project;

        return $this;
    }
}
