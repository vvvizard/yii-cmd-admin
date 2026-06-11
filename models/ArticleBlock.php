<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "article_blocks".
 *
 * @property int $id
 * @property int $article_id
 * @property int|null $style_id
 * @property string $block_type
 * @property string|null $title
 * @property string|null $content
 * @property int|null $sort_order
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 *
 * @property Article $article
 * @property StyleDictionary $style
 */
class ArticleBlock extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName()
    {
        return 'article_blocks';
    }

    public function rules()
    {
        return [
            [['content', 'title', 'style_id'], 'default', 'value' => null],
            [['sort_order'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['article_id', 'block_type'], 'required'],
            [['article_id', 'style_id', 'sort_order', 'status'], 'integer'],
            [['content'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['block_type', 'title'], 'string', 'max' => 255],
            [['article_id'], 'exist', 'skipOnError' => true, 'targetClass' => Article::class, 'targetAttribute' => ['article_id' => 'id']],
            [['style_id'], 'exist', 'skipOnError' => true, 'targetClass' => StyleDictionary::class, 'targetAttribute' => ['style_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'article_id' => 'Article ID',
            'style_id' => 'Style ID',
            'block_type' => 'Block Type',
            'title' => 'Title',
            'content' => 'Content',
            'sort_order' => 'Sort Order',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public function getArticle()
    {
        return $this->hasOne(Article::class, ['id' => 'article_id']);
    }

    public function getStyle()
    {
        return $this->hasOne(StyleDictionary::class, ['id' => 'style_id']);
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }

    public static function getBlocksByArticle($articleId, $activeOnly = true)
    {
        $query = self::find()
            ->where(['article_id' => $articleId])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC]);

        if ($activeOnly) {
            $query->andWhere(['status' => self::STATUS_ACTIVE]);
        }

        return $query->all();
    }
}