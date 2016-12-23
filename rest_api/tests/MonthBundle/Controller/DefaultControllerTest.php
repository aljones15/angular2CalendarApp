<?php

namespace MonthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use MonthBundle\Entity\Day;

class DefaultControllerTest extends WebTestCase
{


    private function getSerializer(){

      $TestEncoders = array(new XmlEncoder(), new JsonEncoder());

      $TestNormalizer = array(new ArrayDenormalizer(),
                              new GetSetMethodNormalizer());

      return new Serializer($TestNormalizer, $TestEncoders);
    }

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


    private function fromJson($string){
       $serializer = $this->getSerializer();
       $result = $serializer->deserialize($string, 'Day[]', 'json');
       var_dump($result);
    }

    public function testIndex()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertContains('Hello World', $client->getResponse()->getContent());
    }

    public function testGetExistingMonth(){

        $client = static::createClient();

        $crawler = $client->request('GET', '/month/12/year/2016');

        $this->assertTrue(
          $client->getResponse()->headers->contains('Content-Type', 'application/json'),
        'the "Content-Type" header is "application/json"' // optional message shown on failure
        );

        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $content = $client->getResponse()->getContent();
        $this->assertGreaterThan(0, strlen($content));
        //$this->fromJson($content);
    }
}
