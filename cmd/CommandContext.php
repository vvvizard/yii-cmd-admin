<?php

namespace app\cmd;

use Yii;

class CommandContext
{
   private $params = [];
   private $error = [];
   
   public function __construct(){
         $this->params = Yii::$app->request->getBodyParams();
   }

   public function addParam( string $key, $val){
    $this->params[$key] = $val;
   }

   public function get(string $key): string
   {
    return $this->params[$key] ?: null ;
   }

   public function setError($error){
    $this->error = $error;
   }

   public function getError(){
    return $this->error;
   }
}
