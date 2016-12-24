<?php

namespace MonthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use MonthBundle\Entity\Day;

class DefaultControllerTest extends WebTestCase
{



    private function sendJson($uri, $json, $client, $method){

      $request = $client->request(
        $method,
        $uri,
        array(),
        array(),
        array('CONTENT_TYPE' => 'application/json'),
        $json
      );

      return $request;
    }


    private function getMonth($year){
       $client = static::createClient();

       $crawler = $client->request('GET', '/month/12/year/' . $year);

       $this->assertTrue(
          $client->getResponse()->headers->contains('Content-Type', 'application/json'),
        'the "Content-Type" header is "application/json"' // optional message shown on failure
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
       return $client->getResponse()->getContent();
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }

    public function testGetExistingMonth(){

        $content = $this->getMonth("2016");
        $this->assertGreaterThan(0, strlen($content));

    }

      public function testGetBlankMonth(){

        $content = $this->getMonth("1900");
        $this->assertLessThan(5, strlen($content));
    }
}
