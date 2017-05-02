<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $uid
 * @property integer $cateid
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $desc
 * @property string $photo
 * @property string $price
 * @property integer $count_love
 * @property integer $stock
 * @property string $address
 * @property string $mobile
 * @property string $qq
 * @property string $weixin
 * @property string $email
 * @property string $lng
 * @property string $lat
 * @property integer $is_rec
 * @property integer $unit
 */
class Goods extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods';
    }

    /**
     * @inheritdoc
     */
//     public function rules()
//     {
//         return [
//             [['uid', 'cateid', 'created_at', 'updated_at', 'count_love', 'stock', 'is_rec', 'unit'], 'integer'],
//             [['desc'], 'string'],
//             [['price'], 'number'],
//             [['user_guid'], 'string', 'max' => 48],
//             [['name', 'photo'], 'string', 'max' => 255],
//             [['address'], 'string', 'max' => 128],
//             [['mobile', 'qq', 'weixin', 'email'], 'string', 'max' => 20],
//             [['lng', 'lat'], 'string', 'max' => 30]
//         ];
//     }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_guid' => 'User Guid',
            'uid' => 'Uid',
            'cateid' => '分类ID',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'name' => '商品名称',
            'desc' => '描述',
            'photo' => '产品图片',
            'price' => '价格',
            'count_love' => '收藏数',
            'stock' => '库存',
            'address' => '地址',
            'mobile' => '电话',
            'qq' => 'QQ',
            'weixin' => '微信',
            'email' => '邮箱',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'is_rec' => '是否推荐',
            'unit' => '单位',
        ];
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
    public function getUserAuth(){
        return $this->hasOne(UserAuth::className(), ['user_guid'=>'user_guid']);
    }
}
