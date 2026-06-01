<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use app\cmd\{CommandContext, CommandFactory, Command, QueryParser};
use Exception;




class AdminCmdController extends Controller
{

    protected $context;

    public function beforeAction($action)
    {
        $this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }
    public function actionCmd()
    {
        Yii::$app->params;
        try {
            $data = json_decode(file_get_contents('php://input'), true);
            $query = new QueryParser($data['cmd']);
            $context = new CommandContext($query);
            $cmd = CommandFactory::getCommand($query->getCommandTitle());
            $cmd->checkRequiredParams($context->getParams());
            $cmd->execute($context);
        } catch (Exception $e) {
            $response = Yii::$app->response;
            $response->format = \yii\web\Response::FORMAT_JSON;
            $response->data = ['terminalMessage' => $e->getMessage()];
        }
    }
}
