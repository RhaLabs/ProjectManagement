<?php

namespace Rha\ProjectManagementBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class StateControllerTest extends WebTestCase
{
    public function testGetstate()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/state/{abbreviation}');
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');
    }
}
