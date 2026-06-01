<?php

namespace app\cmd\Commands\Article;

use app\cmd\{Command, CommandContext};
use app\models\Category;
use Yii;
use yii\db\ActiveRecord;

class ArticleCreateCommand extends Command
{

    private $title = 'ArticleCreate';

    public $requiredParams = ['title', 'content'];

    public function execute(CommandContext $context): bool
    {
        if (!$this->model instanceof ActiveRecord || empty($this->model)) {
            throw new \Exception("wrong or empty model property");
        }

        $this->model->title = $context->get('title');
        if (!empty($context->get('categoryTitle'))) {
            $category = Category::find()->where(['title' => $context->get('categoryTitle')])->one();
            $this->model->category_id = $category->id;
        }

        if (!empty($context->get('categoryID'))) {
            $this->model->category_id = $context->get('categoryID');
        }

        $this->model->content = $context->get('content');
        $userId = $context->get('userId');
        if (!$userId) {
            throw new \Exception("User ID is required");
        }
        $this->model->user_id = $userId;
        $this->model->save();

        $this->jsonResponse($this->terminalMessage('article created with id: ' . Yii::$app->db->getLastInsertID()));


        return true;
    }

    public function checkRequiredParams($inputParams)
    {
        $missedParams = [];
        foreach ($this->requiredParams as $param) {
            if (!\array_key_exists($param, $inputParams)) {
                $missedParams[] = $param;
            }
        }

        if (
            (in_array('categoryID', $missedParams)
                || in_array('categoryTitle', $missedParams))
            && count($missedParams) == 1
        ) {
            return true;
        }

        if (!empty($missedParams)) {
            throw new \Exception('Missed required params: ' . implode(', ', $missedParams));
        }

        return true;
    }


}