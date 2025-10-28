<?php
namespace app\cmd;

use app\cmd\CommandContext;
use Yii;
abstract class Command
{
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

}
