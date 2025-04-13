<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "language-directions".
 *
 * @property int $id
 * @property int $language_from
 * @property int $language_to
 *
 * @property Language $languageFrom
 * @property Language $languageTo
 */
class LanguageDirection extends ActiveRecord
{
    public static function tableName()
    {
        return 'language_directions';
    }

    public function rules()
    {
        return [
            [['language_from', 'language_to'], 'required'],
            [['language_from', 'language_to'], 'integer'],
            [['language_from', 'language_to'], 'unique', 'targetAttribute' => ['language_from', 'language_to']],
            ['language_from', 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language_from' => 'id']],
            ['language_to', 'exist', 'skipOnError' => true, 'targetClass' => Language::class, 'targetAttribute' => ['language_to' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'language_from' => 'Language From',
            'language_to' => 'Language To',
        ];
    }

    public function getLanguageFrom()
    {
        return $this->hasOne(Language::class, ['id' => 'language_from']);
    }

    public function getLanguageTo()
    {
        return $this->hasOne(Language::class, ['id' => 'language_to']);
    }

    public function getLanguagesFormatted()
    {
        return  $this->getLanguageFrom()->one()->code .
                ' - ' .
                $this->getLanguageTo()->one()->code;
    }

    public function getUserLanguageDirection()
    {
        return $this->hasMany(UserLanguageDirection::class, ['language_direction_id' => 'id']);
    }

    public function getCapacity()
    {
        $this->getUserLanguageDirection()
            ->joinWith('user')
            ->where(['user.in_house' => 1])
            ->sum('speed');
    }

    public function getTasks()
    {
        return $this->hasMany(Task::class, ['language_direction_id' => 'id']);
    }

    public function getWork()
    {
        $this->getTasks()->where(['status' => Task::STATUS_WAITING])->sum('words');
    }
}