<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%tasks}}`.
 */
class m250413_125357_create_tasks_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('tasks', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->null(),
            'language_direction_id' => $this->integer()->notNull(),
            'status' => $this->string()->defaultValue('waiting'),
            'words' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-tasks-language_direction_id',
            'tasks',
            'language_direction_id',
            'language_directions',
            'id',
            'CASCADE',
            'CASCADE'
        );
    }

    public function safeDown()
    {
        $this->dropForeignKey('fk-tasks-language_direction_id', 'tasks');
        $this->dropTable('tasks');
    }
}
