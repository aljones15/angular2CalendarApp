<?php

// MonthBundle/ViewModels/CalendarResponse.php

namespace MonthBundle\ViewModels;

use Symfony\Component\HttpFoundation\JsonResponse;
use MonthBundle\ViewModels\BaseResponse;

class CalendarResponse extends BaseResponse {

  public $days;
  public $errors;

  public function __construct($days, $errors){
    $this->days = $days;
    $this->errors = $errors;
  }

  public function toJsonResponse(){
    $response = new JsonResponse($this->toJson());
    return $this->toCors($response);
  }

}
