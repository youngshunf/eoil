<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_sign".
 *
 * @property integer $id
 * @property string $user_guid
 * @property string $sign_date
 * @property integer $created_at
 */
class UserSign extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_sign';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['user_guid'], 'string', 'max' => 48],
            [['sign_date'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_guid' => 'User Guid',
            'sign_date' => '签到日期',
            'created_at' => 'Created At',
        ];
    }
}
