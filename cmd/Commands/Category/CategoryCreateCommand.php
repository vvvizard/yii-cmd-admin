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

        if (!empty($context->get('parentCategoryTitle'))) {
            $category = Category::find()->where(['title' => $context->get('parentCategoryTitle')])->one();
            $this->model->parent_category_id = $category->id;
        }

        if (!empty($context->get('parentCategoryID'))) {
            $this->model->parent_category_id = $context->get('parentCategoryID');
        }


        $this->model->title = $context->get('title');
        $this->model->description = $context->get('description');
        $this->model->save();

        $this->jsonResponse($this->terminalMessage('category created with id: ' . Yii::$app->db->getLastInsertID()));


        return true;
    }

}