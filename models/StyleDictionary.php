<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "style_dictionary".
 *
 * @property int $id
 * @property string $name
 * @property string $code
 * @property string|null $description
 * @property string|null $styles
 * @property int $status
 * @property string|null $created_at
 * @property string|null $updated_at
 */
class StyleDictionary extends \yii\db\ActiveRecord
{
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 0;

    public static function tableName()
    {
        return 'style_dictionary';
    }

    public function rules()
    {
        return [
            [['styles', 'description'], 'default', 'value' => null],
            [['status'], 'default', 'value' => self::STATUS_ACTIVE],
            [['name', 'code'], 'required'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['description', 'styles'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['name', 'code'], 'string', 'max' => 255],
            [['code'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'code' => 'Code',
            'description' => 'Description',
            'styles' => 'Styles',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getStatusList()
    {
        return [
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
        ];
    }
}