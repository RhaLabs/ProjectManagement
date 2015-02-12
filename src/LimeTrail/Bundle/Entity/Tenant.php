<?php

namespace LimeTrail\Bundle\Entity;

use APY\DataGridBundle\Grid\Mapping as GRID;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Application\GlobalBundle\Entity\Tenant as AbstractTenant;

/**
 * @ORM\Entity
 * @ORM\Table(name="tenant", indexes=
        {
          @ORM\Index(name="tenant_idx", columns={"tenant"}),
          @ORM\Index(name="type_idx", columns={"type"}),
          @ORM\Index(name="date_idx", columns={"date"})
        }
      )
 */
class Tenant extends AbstractTenant
{
    /**
     * @ORM\ManyToMany(targetEntity="ProjectInformation", mappedBy="tenants")
     *
     * @GRID\Column(field="project.id", title="project_id", visible=false)
     */
    private $project;
    
    public function getProject()
    {
        return $this->project;
    }
    
    public function setProject($project)
    {
        $this->project->add($project);
      
        return $this;
    }
    
    public function addProject($project)
    {
        $this->project->add($project);
        
        return $this;
    }
    
    public function __construct()
    {
        $this->project = new ArrayCollection();
    }
    
    public function __toString()
    {
        return get_class($this);
    }
}
