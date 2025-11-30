<?php

namespace app\cmd\Commands;

use app\cmd\{Command, CommandContext};
use app\models\Category;
use Yii;

class CategoryCommand extends Command
{

    private $title = 'Category';

    public function execute(CommandContext $context): bool
    {
        $method = \strval($context->getFirstParamKey());
        if (method_exists($this, $method)) {
            $this->$method($context);
        } else {
            $this->handleContext($context);
        }

        $this->jsonResponse(['terminalMessage' => 'Do you really want to test this ? [Yes, No] ']);
        return true;
    }

    protected function list(CommandContext $context)
    {

    }

    protected function info(CommandContext $context)
    {

    }

    protected function create(CommandContext $context)
    {
        $command = new CategoryCreateCommand();
        $command->checkReqiredParams($context->getParams());
        // $category = new Category();

    }

    protected function edit(CommandContext $context)
    {

    }

    protected function delete(CommandContext $context)
    {

    }

    protected function handleContext(CommandContext $context)
    {

    }

}