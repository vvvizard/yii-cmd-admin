<?php

namespace app\cmd\Commands\Category;

use app\cmd\{Command, CommandContext};
use app\models\Category;
use Yii;
use yii\db\ActiveRecord;

class CategoryCreateCommand extends Command
{

    private $title = 'CategoryCreate';

    public $requiredParams = ['title', 'description'];

    public function execute(CommandContext $context): bool
    {
        if (!$this->model instanceof ActiveRecord || empty($this->model)) {
            throw new \Exception("wrong or empty model property");
        }

        $this->model->title = $context->get('title');
        $this->model->description = $context->get('description');
        $this->model->save();

        $this->jsonResponse($this->terminalMessage('category created with id: ' . $this->model->id));
        

        return true;
    }

}