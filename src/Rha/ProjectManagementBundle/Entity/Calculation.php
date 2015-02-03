<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Entity(repositoryClass="Rha\ProjectManagementBundle\Repository\CalculationRepository")
 * @ORM\Table(name="calculation", indexes=
        {
          @ORM\Index(name="date_idx", columns={"createDate"})
        }
      )
 */
class Calculation extends BaseRates
{
}
