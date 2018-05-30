<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tokens".
 *
 * @property string $token
 * @property string $create_date
 */
class Tokens extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tokens';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['token'], 'required'],
            [['create_date'], 'safe'],
            [['token'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'token' => 'Token',
            'create_date' => 'Create Date',
        ];
    }
}
