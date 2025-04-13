<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%user_language_directions}}`.
 */
class m250412_173645_create_user_language_directions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%user_language_directions}}', [
            'id' => $this->primaryKey(),
            'user_id' => $this->integer()->notNull(),
            'language_direction_id' => $this->integer()->notNull(),
            'speed' => $this->float()->defaultValue(1), // Default speed is 1
        ]);

        // Create foreign keys
        $this->addForeignKey(
            'fk-user_language_directions-user_id',
            '{{%user_language_directions}}',
            'user_id',
            'user',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-user_language_directions-language_direction_id',
            '{{%user_language_directions}}',
            'language_direction_id',
            'language_directions',
            'id',
            'RESTRICT',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropForeignKey('fk-user_language_directions-language_direction_id', '{{%user_language_directions}}');
        $this->dropForeignKey('fk-user_language_directions-user_id', '{{%user_language_directions}}');

        $this->dropTable('{{%user_language_directions}}');
    }
}
