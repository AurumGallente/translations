<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%language-directions}}`.
 */
class m250412_135640_create_language_directions_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $this->createTable('language_directions', [
            'id' => $this->primaryKey(),
            'language_from' => $this->integer()->notNull(),
            'language_to' => $this->integer()->notNull(),
        ]);

        // Adding foreign key constraints
        $this->addForeignKey(
            'fk-language-directions-from',
            'language-directions',
            'language_from',
            'languages',
            'id',
            'RESTRICT'
        );

        $this->addForeignKey(
            'fk-language-directions-to',
            'language-directions',
            'language_to',
            'languages',
            'id',
            'RESTRICT'
        );
    }

    public function down()
    {
        // Drop foreign key constraints first
        $this->dropForeignKey('fk-language-directions-from', 'language-directions');
        $this->dropForeignKey('fk-language-directions-to', 'language-directions');

        // Drop the table
        $this->dropTable('language-directions');
    }
}
