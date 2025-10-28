<?php

use yii\db\Migration;

class m250926_191841_article extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('article', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'category_id' => $this->integer(11)->notNull(),
            'content' => $this->text(),
            'user_id' => $this->integer(11)->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => 'timestamp DEFAULT current_timestamp',
            'updated_at' => 'timestamp DEFAULT current_timestamp ON UPDATE current_timestamp',
        ]);
        $this->addCommentOnTable('article', 'article table');

        $this->createIndex(
            'idx-article-user_id',
            'article',
            'user_id'
        );

        $this->addForeignKey(
            'fk-article-user_id',
            'article',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

            $this->createIndex(
            'idx-article-category_id',
            'article',
            'category_id'
        );

        $this->addForeignKey(
            'fk-article-category_id',
            'article',
            'category_id',
            'category',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('article');
    }

}
