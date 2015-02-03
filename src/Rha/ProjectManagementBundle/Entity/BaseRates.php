<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\MappedSuperclass
 */
class BaseRates extends \Application\GlobalBundle\Entity\BaseEntity
{
    /**
     * @ORM\Column(type="integer")
     */
    protected $predesignRate;

    public function getPreDesignRate()
    {
        return $this->predesignRate;
    }

    public function setPreDesignRate($value)
    {
        $this->predesignRate = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $designRate;

    public function getDesignRate()
    {
        return $this->designRate;
    }

    public function setDesignRate($value)
    {
        $this->designRate = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $schematicDesignRate;

    public function getSchematicDesignRate()
    {
        return $this->schematicDesignRate;
    }

    public function setSchematicDesignRate($value)
    {
        $this->schematicDesignRate = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $designDevelopmentRate;

    public function getDesignDevelopmentRate()
    {
        return $this->designDevelopmentRate;
    }

    public function setDesignDevelopmentRate($value)
    {
        $this->designDevelopmentRate = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $constructionDocumentsRate;

    public function getConstructionDocumentsRate()
    {
        return $this->constructionDocumentsRate;
    }

    public function setConstructionDocumentsRate($value)
    {
        $this->constructionDocumentsRate = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $constructionAdminRate;

    public function getConstructionAdminRate()
    {
        return $this->constructionAdminRate;
    }

    public function setConstructionAdminRate($value)
    {
        $this->constructionAdminRate = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $qualityControlRate;

    public function getQualityControlRate()
    {
        return $this->qualityControlRate;
    }

    public function setQualityControlRate($value)
    {
        $this->qualityControlRate = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $permittingRate;

    public function getPermittingRate()
    {
        return $this->permittingRate;
    }

    public function setPermittingRate($value)
    {
        $this->permittingRate = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $baseRate;

    public function getBaseRate()
    {
        return $this->baseRate;
    }

    public function setBaseRate($value)
    {
        $this->baseRate = $value;

        return $this;
    }

    /**
     * @ORM\Column(type="integer")
     */
    protected $baseWithOverheadRate;

    public function getBaseWithOverheadRate()
    {
        return $this->baseWithOverheadRate;
    }

    public function setBaseWithOverheadRate($value)
    {
        $this->baseWithOverheadRate = $value;

        return $this;
    }
}
