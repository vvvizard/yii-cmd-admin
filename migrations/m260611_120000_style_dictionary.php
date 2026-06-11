<?php

use yii\db\Migration;

class m260611_120000_style_dictionary extends Migration
{
    public function safeUp()
    {
        $this->createTable('style_dictionary', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
            'code' => $this->string()->notNull(),
            'description' => $this->text(),
            'styles' => $this->text(),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => 'timestamp DEFAULT current_timestamp',
            'updated_at' => 'timestamp DEFAULT current_timestamp ON UPDATE current_timestamp',
        ]);
        $this->addCommentOnTable('style_dictionary', 'Style dictionary table');

        $this->createIndex(
            'idx-style_dictionary-code',
            'style_dictionary',
            'code',
            true
        );
    }

    public function safeDown()
    {
        $this->dropTable('style_dictionary');
    }
}