<?php

use yii\db\Migration;

class m250413_135329_add_in_house_and_freelancer_to_user_table extends Migration
{
    public function safeUp()
    {
        // Adding 'in_house' and 'freelancer' fields to 'user' table
        $this->addColumn('user', 'in_house', $this->smallInteger()->defaultValue(1));
        $this->addColumn('user', 'freelancer', $this->smallInteger()->defaultValue(0));
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // Drop the columns if rolling back
        $this->dropColumn('user', 'in_house');
        $this->dropColumn('user', 'freelancer');
    }
}
