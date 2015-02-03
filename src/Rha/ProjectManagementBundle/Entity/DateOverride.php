<?php

namespace Rha\ProjectManagementBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="date_override", indexes=
      {
        @ORM\Index(name="pwo_idx", columns={"pwoPrj"}),
        @ORM\Index(name="pwo_a_idx", columns={"pwoAct"}),
        @ORM\Index(name="otp_idx", columns={"otpPrj"}),
        @ORM\Index(name="otp_a_idx", columns={"otpAct"}),
        @ORM\Index(name="otb_idx", columns={"otbPrj"}),
        @ORM\Index(name="otb_a_idx", columns={"otbAct"}),
        @ORM\Index(name="poss_idx", columns={"possPrj"}),
        @ORM\Index(name="poss_a_idx", columns={"possAct"}),
        @ORM\Index(name="go_idx", columns={"goPrj"}),
        @ORM\Index(name="go_idx", columns={"goAct"})
      }
    )
 */
class DateOverride extends \Application\GlobalBundle\Entity\BaseDateOverride
{
}
