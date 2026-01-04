<?php

namespace app\cmd\Commands;

use app\cmd\{Command, CommandContext};
use app\cmd\Commands\Article\ArticleCreateCommand;
use app\models\Article;
use Yii;

class ArticleCommand extends Command
{

    private $title = 'Article';

    public function execute(CommandContext $context): bool
    {
        $method = \strval($context->getFirstParamKey());
        if (method_exists($this, $method)) {
            $this->model = new Article();
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
        $command = new ArticleCreateCommand();
        $command->checkRequiredParams($context->getParams());
        $command->setModel($this->model);
        $command->execute($context);
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