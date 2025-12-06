<?php

namespace app\cmd\Commands;

use app\cmd\{Command, CommandContext};
use app\cmd\Commands\Category\CategoryCreateCommand;
use app\models\Category;
use Yii;

class CategoryCommand extends Command
{

    private $title = 'Category';

    public function execute(CommandContext $context): bool
    {
        $method = \strval($context->getFirstParamKey());
        if (method_exists($this, $method)) {
            $this->model = new Category();
            $this->$method($context);
        } else {
            throw new \Exception("No such command for : ". $this->title);
        }
        
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
        $command->checkRequiredParams($context->getParams());
        $command->setModel($this->model);
        $command->execute($context);
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