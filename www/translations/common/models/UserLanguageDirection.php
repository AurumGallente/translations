<?php

namespace common\models;

use yii\db\ActiveRecord;

class UserLanguageDirection extends ActiveRecord
{
    public static function tableName()
    {
        return 'user_language_directions';
    }

    public function rules()
    {
        return [
            [['user_id', 'language_direction_id'], 'required'],
            [['user_id', 'language_direction_id'], 'integer'],
            [['speed'], 'number'],
            [['speed'], 'default', 'value' => 1], // Set default speed to 1
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'language_direction_id' => 'Language Direction ID',
            'speed' => 'Speed',
        ];
    }

    // Define relationships
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    public function getLanguageDirection()
    {
        return $this->hasOne(LanguageDirection::class, ['id' => 'language_direction_id']);
    }

}
