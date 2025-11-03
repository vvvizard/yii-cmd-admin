<?php

namespace app\cmd;

use app\cmd\QueryParser;
use Yii;

class CommandContext
{
      private $params = [];
      private $error = [];

      protected $query;
      public function __construct(QueryParser $query)
      {
              $this->initQuery($query);
      }

      protected function initQuery($query)
      {
            $this->query = $query;
            if ($query->get('callYesNo')) {
                  $this->params['callYesNo'] = $query->getQueryString();
                  return;
            }
            $this->params = $this->query->parseParams();
      }

      public function addParam(string $key, $val)
      {
            $this->params[$key] = $val;
      }

      public function get(string $key)
      {
            return $this->params[$key] ?? null;
      }

      public function getParams(){
            return $this->params;
      }

      public function setError($error)
      {
            $this->error = $error;
      }

      public function getError()
      {
            return $this->error;
      }
}
