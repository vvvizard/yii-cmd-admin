<?php

namespace app\cmd\Commands;

use app\cmd\{Command, CommandContext};
use Yii;
class TestCommand extends Command
{

    private $title = "Test";
    public function execute(CommandContext $context): bool
    {
        if (empty($context->get('callYesNo'))) {
            Yii::$app->session->setFlash('lastCall', "Test");
            Yii::$app->session->setFlash('YesNoQuestion');
        } else {
            $this->handleContext($context);
        }

        $this->jsonResponse(['terminalMessage' => 'Do you really want to test this ? [Yes, No] ']);
        return true;
    }

    protected function handleContext($context)
    {

        $call = $context->get('callYesNo');

        if ($call == "Yes") {
            $message = "So you should code some commands, and check it. Try to find out if there are some docs on it. (it possible they will appear soon, or someday ...)";
        } elseif ($call == "No") {
            $message = "Hm, maybe u'll try it later, good luck )";
        } else {
            $message = "Bad command";
        }

        $this->jsonResponse(
            $this->terminalMessage($message)
        );

    }

}