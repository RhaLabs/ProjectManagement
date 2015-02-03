<?php

namespace LimeTrail\Bundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Application\GlobalBundle\Entity\ChangeInitiation as AbstractChange;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="LimeTrail\Bundle\Repository\ChangeInitiationRepository")
 * @ORM\Table(name="change_initiation", indexes=
        {
          @ORM\Index(name="number_idx", columns={"number"}),
          @ORM\Index(name="title_idx", columns={"title"})
        }
      )
 */
class ChangeInitiation extends AbstractChange
{
    /**
     * @ORM\OneToMany(targetEntity="ProjectChangeInitiation", mappedBy="change")
     */
    private $projectChange;
    
    public function getProjectChange()
    {
      return $this->projectChange;
    }
    
    public function setProjectChange($project)
    {
      $this->projectChange[] = $project;
      
      return $this;
    }
    
    /** 
      * @ORM\ManyToMany(targetEntity="ChangeScope", inversedBy="change")
      * @ORM\JoinTable(name="change_initiations_scopes",
          joinColumns={
            @ORM\JoinColumn(name="change_id", referencedColumnName="id")},
          inverseJoinColumns={
            @ORM\JoinColumn(name="scope_id", referencedColumnName="id")}
        )
      */
    protected $scopes;
    
    public function getScopes()
    {
        return $this->scopes;
    }

    public function setScope(\LimeTrail\Bundle\Entity\ChangeScope $scope)
    {
        $this->scopes->add($scope);
        
        $scope->addChange($this);

        return $this;
    }

    public function setScopes($scopes)
    {
        if (is_array($scopes)) {
            foreach ($scopes as $scope) {
                $this->setScope($scope);
            }

            return $this;
        }

        return $this->setScope($scopes);
    }

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
    
    public function __construct()
    {
        $this->projectChange = new ArrayCollection();
        $this->scopes = new ArrayCollection();
    }
    
    public function __toString()
    {
      return get_class($this);
    }
}
