<?php

namespace app\cmd\Commands;

use app\cmd\{Command, CommandContext};
use app\cmd\Commands\Category\CategoryCreateCommand;
use app\models\Category;
use Yii;

class LoadFromFolderCommand extends Command
{

    private $title = 'LoadFromFolder';

    public $requiredParams = ['folder'];

    public function execute(CommandContext $context): bool
    {
        $method = \strval($context->getFirstParamKey());
        if (method_exists($this, $method)) {
            
        } else {
            throw new \Exception("No such command for : ". $this->title);
        }
        
        return true;
    }
    protected function handleContext(CommandContext $context)
    {

    }

}