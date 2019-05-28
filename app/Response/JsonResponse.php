<?php

namespace App\Response;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Response;

class JsonResponse extends Model
{
  private $data = array();
  private $errors = array();
  private $message = "Success";
  private $statusCode = 200;



  /*******************************************************
  * Accesseurs en lecture                               *
  *******************************************************/
  public function getErrors ()
  {
    return $this->errors;
  }

  public function getMessage(){
    return $this->message;
  }

  public function getData ()
  {
    return $this->data;
  }


  public function getStatusCode()
  {
    return $this->statusCode;
  }

  /**************************************************
  * Accesseurs en écriture                          *
  **************************************************/
  public function setStatusCode($code)
  {
    $this->statusCode = $code;
    return $this;
  }


  public function setMessage($message){
    $this->message = $message;
    return $this->throw();
  }


  public function setData($value)
  {
    if($value == null){
      return;
    }
    if(!is_array($value)){
      $this->data = $value;
    }else{
      $this->data = $value;
    }

    return $this->throw();
  }


  public function error($index, $value = null)
  {
    if (is_array($index)) {
      return $this->mergeErrors($index);
    }
    if (is_null($value)) {
      $this->errors[] = $index;
    } else {
      $this->errors[$index] = $value;
    }
    return $this;
  }



  public function mergeErrors(array $errors)
  {
    $this->errors = array_merge($this->errors, $errors);
    return $this;
  }



  public function addErrors(array $errors)
  {
    $this->errors = $this->errors + $errors;
    return $this->throw();;
  }

  public function throw(){
    if(empty($this->data) && $this->message == "Success"){
      $this->error(["Object not found"]);
      $this->setMessage("Something went wrong");
      $this->statusCode = 410;
    }
    return response()->json($this->toArray(), $this->statusCode);
  }


  public function toArray ()
  {
    $data = [
      'errors' => $this->errors,
      'result' => [
        'data' => $this->data,
        'message' => $this->message
      ],
      'status_code' => $this->statusCode
    ];
    return $data;
  }
}
