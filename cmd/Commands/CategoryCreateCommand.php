<?php

namespace app\cmd\Commands;

use app\cmd\{Command, CommandContext};
use app\models\Category;
use Yii;

class CategoryCreateCommand extends Command
{

    private $title = 'CategoryCreate';

    public $requiredParams = ['title', 'description'];

    public function execute(CommandContext $context): bool
    {
        $method = \strval($context->getFirstParamKey());
        if (method_exists($this, $method)) {
            $this->$method();
        } 
        

        return true;
    }

}