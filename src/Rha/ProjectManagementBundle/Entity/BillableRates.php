<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\BillableRatesRepository")
 * @ORM\Table(name="billable_rates", indexes=
 {
 @ORM\Index(name="date_idx", columns={"createDate"})
 }
 )
 */
class BillableRates extends BaseRates
{
}
