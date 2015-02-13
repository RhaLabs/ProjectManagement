<?php

namespace LimeTrail\Bundle\Form\Data;

use Symfony\Component\Validator\Constraints as Assert;

class StoreProjectData
{
    /**
     * @Assert\GreaterThanOrEqual(
     *     value = 0
     * )
     */
    public $storeNumber;

    /**
     * @Assert\GreaterThanOrEqual(
     *     value = 0
     * )
     */
    public $sequenceNumber;

    /**
     * @Assert\GreaterThanOrEqual(
     *     value = 0
     * )
     */
    public $projectNumber;

    /**
     * @Assert\GreaterThanOrEqual(
     *     value = 0
     * )
     */
    public $projectPhase;

    /**
     * @Assert\NotNull()
     */
    public $confidential;

    /**
     * @Assert\NotNull()
     */
    public $combo;

    /**
     * @Assert\NotNull()
     */
    public $manageSitesDifferently;

    /**
     * @Assert\Length(
     *      min = 2,
     *      max = 50,
     *      minMessage = "SAP must be at least {{ limit }} characters long",
     *      maxMessage = "SAP cannot be longer than {{ limit }} characters long"
     * )
     */
    public $sap;

    /**
     * @Assert\GreaterThanOrEqual(
     *     value = 0
     * )
     */
    public $storeSquareFootage;

    /**
     * @Assert\GreaterThanOrEqual(
     *     value = 0
     * )
     */
    public $increaseSquareFootage;

    /**
     * @Assert\GreaterThanOrEqual(
     *     value = 0
     * )
     */
    public $prjTotalSquareFootage;

    /**
     * @Assert\GreaterThanOrEqual(
     *     value = 0
     * )
     */
    public $actTotalSquareFootage;

    public $user;

    /**
     * @Assert\NotBlank()
     */
    public $state;

    /**
     * @Assert\NotBlank()
     */
    public $city;

    /**
     * @Assert\NotBlank()
     */
    public $canonicalName;

    /**
     * @Assert\NotBlank()
     */
    public $storeType;

    /**
     * @Assert\NotBlank()
     */
    public $projectType;

    public function __construct()
    {
        $this->projectPhase = 0;
        $this->confidential = false;
        $this->combo = false;
        $this->manageSitesDifferently = false;
        $this->sap = 'unknown';
        $this->storeSquareFootage = 0;
        $this->increaseSquareFootage = 0;
        $this->prjTotalSquareFootage = 0;
        $this->actTotalSquareFootage = 0;
    }
}
