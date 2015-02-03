<?php

namespace LimeTrail\Bundle\Tests\Entity;

use LimeTrail\Bundle\Entity\Dates;

class DateTest extends \PHPUnit_Framework_TestCase
{
    public function testGetDateChanged()
    {
        $date = new Dates();

        $date->setDateChanged('retPrj', true);

        $result = $date->getDateChanged('retPrj');

        $this->assertEquals(true, $result);
    }
}
