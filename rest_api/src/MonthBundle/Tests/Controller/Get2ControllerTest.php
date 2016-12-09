<?php

namespace MonthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class Get2ControllerTest extends WebTestCase
{
    public function testGetmonth2()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/month/{month_id}/year/{year_id}');
    }

}
