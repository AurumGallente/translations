<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "languages".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 */
class Language extends ActiveRecord
{
    public static function tableName()
    {
        return 'languages'; // Your table name
    }

    public function rules()
    {
        return [
            // Other validation rules...
            [['code', 'name'], 'unique', 'message' => 'This {attribute} has already been taken.'],
            [['code', 'name'], 'required'],
            [['code'], 'string', 'max' => 5],
            [['name'], 'string', 'max' => 255],
        ];
    }
}
