<?php

// MonthBundle/ViewModels/BaseResponse.php

namespace MonthBundle\ViewModels;

use MonthBundle\Utils\JsonParser;

class BaseResponse {

    public function toCors($response){
    $ALLOWED_ORIGINS = '*';
    $ALL_METHODS = 'PUT, GET, POST, OPTIONS';
    $ALLOWED_HEADERS = 'Access-Control-Allow-Headers, Origin, Accept, X-Requested-With, Content-Type, Access-Control-Request-Method, Access-Control-Request-Headers';
    $response->headers->set('Access-Control-Allow-Origin', $ALLOWED_ORIGINS);
    $response->headers->set('Access-Control-Allow-Methods', $ALL_METHODS);
    $response->headers->set('Access-Control-Allow-Headers', $ALLOWED_HEADERS);
    return $response;
  }

    public function toJson(){
    $parser = new JsonParser();
    return $parser->entityToJson($this);
  }

}
