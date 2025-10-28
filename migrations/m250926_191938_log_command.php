<?php

use yii\db\Migration;

class m250926_191938_log_command extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('log_command', [
            'id' => $this->primaryKey(),
            'command' => $this->string()->notNull(),
            'params' => $this->bigInteger(32)->notNull(),
            'user_id' => $this->integer(11),
            'result' => $this->bigInteger()->notNull(),
            'status' => $this->smallInteger()->notNull()->defaultValue(10),
            'created_at' => 'timestamp DEFAULT current_timestamp',
            'updated_at' => 'timestamp DEFAULT current_timestamp ON UPDATE current_timestamp',
        ]);
        $this->addCommentOnTable('log_command', 'log_command table');
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('log_command');
    }

}
