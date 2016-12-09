<?php

namespace MonthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class GetControllerTest extends WebTestCase
{
    public function testGetmonth()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/month/year');
    }

}
