<?php

// MonthBundle/ViewModels/ErrorResponse.php

namespace MonthBundle\ViewModels;

use Symfony\Component\HttpFoundation\JsonResponse;
use MonthBundle\ViewModels\BaseResponse;

class ErrorResponse extends BaseResponse {
  public $errors;

  public function __construct($errors){
    $this->errors = $errors;
  }

  public function toJsonResponse(){
  $response = new JsonResponse($this->toJson());
  $response->setStatusCode(400);
  return $this->toCors($response);
}

}
