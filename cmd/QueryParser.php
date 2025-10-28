<?php

namespace app\cmd;

use Yii;

class QueryParser
{
   protected $query;
   private $params = [];
   private $error = [];

   public function __construct($query)
   {
      $this->query = $query;
      $this->checkFlash();
   }

   protected function checkFlash()
   {
      $lastCall = Yii::$app->session->getFlash('lastCall');
      $this->params['lastCall'] = $lastCall;
      $this->params['callYesNo'] = Yii::$app->session->getFlash('YesNoQuestion');
   }

   public function get(string $key)
   {
      return $this->params[$key] ?? null;
   }

   public function parseParams()
   {
      $pattern = '/(\-{2})\w+((=\w+($| ))|($| ))/';
      preg_match_all($pattern, $this->query, $matches);
      foreach ($matches[0] as $key => $param) {

         $param = trim(str_replace('--', '', $param));
         if (str_contains($param, '=')) {
            $parsedParam = explode("=", $param);
            $this->params[$parsedParam[0]] = $parsedParam[1];
         } else {
            $this->params[$param] = true;
         }
      }

      return $this->params;
   }
   public function getCommandTitle()
   {
      $lastCall = $this->getLastCall();
      return $lastCall ?? strtok($this->query, ' ');
   }

   public function getLastCall()
   {
      return $this->params['lastCall'] ?? null;
   }

   public function getQueryString()
   {
      return $this->query;
   }



}
