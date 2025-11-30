<?php
namespace app\cmd;

use app\cmd\CommandContext;
use Yii;
abstract class Command
{
    public $requiredParams = [];

    abstract public function execute(CommandContext $context): bool;

    protected function jsonResponse(array $data)
    {
        $response = Yii::$app->response;
        $response->format = \yii\web\Response::FORMAT_JSON;
        $response->data = $data;
        $response->send();
        return true;
    }

    protected function terminalMessage(string $message)
    {
        return ['terminalMessage' => $message];
    }

    protected function checkRequiredParams($inputParams)
    {
        $inputParamsKeys = array_keys($inputParams);
        $missedParams = [];
        foreach ($this->requiredParams as $param) {
            if (!\array_key_exists($param, $inputParamsKeys)) {
                $missedParams[] = $param;
            }
        }

        if (!empty($missedParams)) {
            throw new \Exception('Missed required params: ' . implode(', ', $missedParams));
        }

        return true;

    }

}
