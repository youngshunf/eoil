<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_location".
 *
 * @property integer $id
 * @property string $user_guid
 * @property string $lng
 * @property string $lat
 * @property string $address
 * @property string $locinfo
 * @property integer $time
 */
class UserLocation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_location';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['time'], 'integer'],
            [['user_guid'], 'string', 'max' => 64],
            [['lng', 'lat'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 128],
            [['locinfo'], 'string', 'max' => 1024]
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
            'lng' => 'Lng',
            'lat' => 'Lat',
            'address' => '地址',
            'locinfo' => '定位信息',
            'time' => '时间',
        ];
    }
}
