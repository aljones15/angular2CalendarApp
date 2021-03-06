<?php

// MonthBundle/Utils/Json.php

namespace MonthBundle\Utils;

use Symfony\Component\Serializer\Serializer;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

class JsonParser
{

  public function getSerializer(){

      $TestEncoders = array(new XmlEncoder(), new JsonEncoder());

      $TestNormalizer = array(new ArrayDenormalizer(),
                              new GetSetMethodNormalizer(),
                              new ObjectNormalizer());

      return new Serializer($TestNormalizer, $TestEncoders);
    }

  public function fromJson($string, $model){
    $serializer = $this->getSerializer();
    $result = $serializer->deserialize($string, $model, 'json');
    var_dump($result);
  }

  public function entityToJson($data){
    $serializer = $this->getSerializer();
    $json = $serializer->serialize($data, 'json');
    return $json;
  }

  private function removeBOM($data) {
    if (0 === strpos(bin2hex($data), 'efbbbf')) {
      return substr($data, 3);
    }
  }

}


