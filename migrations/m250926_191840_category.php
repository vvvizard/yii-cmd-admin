<?php

use yii\db\Migration;

class m250926_191840_category extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('category', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'parent_category_id' => $this->integer(11),
            'description' => $this->string()->notNull(),
            'user_id' => $this->integer(11),
            'status' => $this->smallInteger()->notNull()->defaultValue(0),
            'created_at' => 'timestamp DEFAULT current_timestamp',
            'updated_at' => 'timestamp DEFAULT current_timestamp ON UPDATE current_timestamp',
        ]);
        $this->addCommentOnTable('category', 'Category table');

         $this->createIndex(
            'idx-category-user_id',
            'category',
            'user_id'
        );

         $this->addForeignKey(
            'fk-category-user_id',
            'category',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('category');
    }

}
