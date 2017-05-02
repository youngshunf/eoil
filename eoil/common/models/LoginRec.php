<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "login_rec".
 *
 * @property integer $id
 * @property string $user_guid
 * @property string $ip
 * @property integer $time
 * @property string $ua
 * @property string $lng
 * @property string $lat
 * @property string $address
 */
class LoginRec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'login_rec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'integer'],
            [['user_guid'], 'string', 'max' => 38],
            [['ip'], 'string', 'max' => 20],
            [['ua', 'address'], 'string', 'max' => 255],
            [['lng', 'lat'], 'string', 'max' => 32]
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
            'ip' => 'Ip',
            'time' => 'Time',
            'ua' => 'Ua',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'address' => 'Address',
        ];
    }
}
