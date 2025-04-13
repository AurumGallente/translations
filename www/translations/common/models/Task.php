<?php

namespace common\models;

use Yii;

class Task extends \yii\db\ActiveRecord
{

    const STATUS_IN_PROGRESS = 'in_progress';

    const STATUS_WAITING = 'waiting';

    public static function tableName()
    {
        return 'tasks';
    }

    public function rules()
    {
        return [
            [['language_direction_id', 'words'], 'required'],
            [['language_direction_id', 'words'], 'integer'],
            [['user_id'], 'integer'],
            [['status'], 'string', 'max' => 255],
        ];
    }

    public function getLanguageDirection()
    {
        return $this->hasOne(LanguageDirection::class, ['id' => 'language_direction_id']);
    }

    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}