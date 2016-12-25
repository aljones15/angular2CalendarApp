<?php

namespace MonthBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use MonthBundle\Entity\Day;
use MonthBundle\Utils\JsonParser;



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

    private function dayTemplate($date){

      return sprintf('{"id":"null","day":"2000-01-' . $date . 'T00:00:00.000Z","single":{"selected":true,"price":999,"available":999,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}}', $date);
    }

    private function makeMonth(){
      $monthString = '[%s]';
      $dayArray = array();
      foreach(range(1,31) as $date){
        if($date < 10){
          $d = "0" . $date;
          array_push($dayArray, $this->dayTemplate($d));
        }else {
          array_push($dayArray, $this->dayTemplate($date));
        }
      }
      $dayArray = join(',', $dayArray);
      return sprintf($monthString, $dayArray);
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

    public function testGetExistingMonth(){
        $content = $this->getMonth("2016");
        $this->assertGreaterThan(5, strlen($content));

    }

    public function testGetBlankMonth(){
        $content = $this->getMonth("1900");
        $this->assertLessThan(5, strlen($content));
    }

    public function testUpdateDays(){
      $json = '[{"id":253,"day":"2017-01-01T00:00:00.000Z","single":{"selected":true,"price":999,"available":999,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":254,"day":"2017-01-02T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":255,"day":"2017-01-03T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":256,"day":"2017-01-04T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":257,"day":"2017-01-05T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":258,"day":"2017-01-06T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":259,"day":"2017-01-07T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":260,"day":"2017-01-08T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":261,"day":"2017-01-09T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":262,"day":"2017-01-10T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":263,"day":"2017-01-11T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":264,"day":"2017-01-12T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":265,"day":"2017-01-13T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":266,"day":"2017-01-14T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":267,"day":"2017-01-15T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":268,"day":"2017-01-16T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":269,"day":"2017-01-17T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":270,"day":"2017-01-18T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":271,"day":"2017-01-19T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":272,"day":"2017-01-20T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":273,"day":"2017-01-21T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":274,"day":"2017-01-22T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":275,"day":"2017-01-23T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":276,"day":"2017-01-24T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":277,"day":"2017-01-25T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":278,"day":"2017-01-26T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":279,"day":"2017-01-27T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":280,"day":"2017-01-28T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":281,"day":"2017-01-29T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":282,"day":"2017-01-30T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}},{"id":283,"day":"2017-01-31T00:00:00.000Z","single":{"selected":false,"price":8,"available":8,"type":"single"},"double":{"selected":false,"price":200,"available":3,"type":"double"}}]';
      $client = static::createClient();
      $request = $this->sendJson("/updateMonth", $json, $client, 'PUT');
      $this->assertTrue(
        $client->getResponse()->headers->contains('Content-Type', 'application/json'),
        'the "Content-Type" header is "application/json"' // optional message shown on failure
      );
      $content = $client->getResponse()->getContent();
      $this->assertGreaterThan(5, strlen($content));

    }

      public function testUpdateEmptyDays(){
        $json = '';
        $client = static::createClient();
        $request = $this->sendJson("/updateMonth", $json, $client, 'PUT');
        $this->assertTrue(
          $client->getResponse()->headers->contains('Content-Type', 'application/json'),
          'the "Content-Type" header is "application/json"' // optional message shown on failure
        );
        $content = $client->getResponse()->getContent();
        $this->assertLessThan(5, strlen($content));
    }

    public function testCreateMonth(){
      $client = static::createClient();
      $json = $this->makeMonth();
      $request = $this->sendJson("/createMonth", $json, $client, 'POST');
      $this->assertTrue(
        $client->getResponse()->headers->contains('Content-Type', 'application/json'),
        'the "Content-Type" header is "application/json"' // optional message shown on failure
      );
      $content = $client->getResponse()->getContent();
      $this->assertGreaterThan(5, strlen($content));
    }

    public function testCreateEmptyMonth(){
      $client = static::createClient();
      $json = '';
      $request = $this->sendJson("/createMonth", $json, $client, 'POST');
      $this->assertTrue(
        $client->getResponse()->headers->contains('Content-Type', 'application/json'),
        'the "Content-Type" header is "application/json"' // optional message shown on failure
      );
      $content = $client->getResponse()->getContent();
      $this->assertContains("no_days_added", $content);
    }

}
