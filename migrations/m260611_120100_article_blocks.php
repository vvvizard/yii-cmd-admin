<?php

use yii\db\Migration;

class m260611_120100_article_blocks extends Migration
{
    public function safeUp()
    {
        $this->createTable('article_blocks', [
            'id' => $this->primaryKey(),
            'article_id' => $this->integer(11)->notNull(),
            'style_id' => $this->integer(11),
            'block_type' => $this->string()->notNull(),
            'title' => $this->string(),
            'content' => $this->text(),
            'sort_order' => $this->integer()->defaultValue(0),
            'status' => $this->smallInteger()->notNull()->defaultValue(1),
            'created_at' => 'timestamp DEFAULT current_timestamp',
            'updated_at' => 'timestamp DEFAULT current_timestamp ON UPDATE current_timestamp',
        ]);
        $this->addCommentOnTable('article_blocks', 'Article blocks table');

        $this->createIndex(
            'idx-article_blocks-article_id',
            'article_blocks',
            'article_id'
        );

        $this->addForeignKey(
            'fk-article_blocks-article_id',
            'article_blocks',
            'article_id',
            'article',
            'id',
            'CASCADE'
        );

        $this->createIndex(
            'idx-article_blocks-style_id',
            'article_blocks',
            'style_id'
        );

        $this->addForeignKey(
            'fk-article_blocks-style_id',
            'article_blocks',
            'style_id',
            'style_dictionary',
            'id',
            'SET NULL'
        );
    }

    public function safeDown()
    {
        $this->dropTable('article_blocks');
    }
}