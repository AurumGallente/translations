<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%language}}`.
 */
class m250412_122537_create_languages_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%language}}', [
            'id' => $this->primaryKey(),
            'code' => $this->string(5)->unique(),
            'name' => $this->string('255')->unique(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%language}}');
    }
}
