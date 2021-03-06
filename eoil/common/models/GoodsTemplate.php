<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_template".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $uid
 * @property integer $cateid
 * @property integer $goodsid
 * @property string $goods_user
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $name
 * @property string $desc
 * @property string $photo
 * @property string $price
 * @property integer $stock
 * @property string $address
 * @property string $mobile
 * @property string $qq
 * @property string $weixin
 * @property string $email
 * @property string $lng
 * @property string $lat
 * @property string $unit
 * @property integer $end_time
 */
class GoodsTemplate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_template';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'cateid', 'goodsid', 'created_at', 'updated_at', 'stock', 'end_time'], 'integer'],
            [['desc'], 'string'],
            [['price'], 'number'],
            [['user_guid', 'goods_user'], 'string', 'max' => 48],
            [['name', 'photo'], 'string', 'max' => 255],
            [['address'], 'string', 'max' => 128],
            [['mobile', 'qq', 'weixin', 'email'], 'string', 'max' => 20],
            [['lng', 'lat'], 'string', 'max' => 30],
            [['unit'], 'string', 'max' => 4]
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
            'uid' => 'Uid',
            'cateid' => '分类ID',
            'goodsid' => 'Goodsid',
            'goods_user' => 'Goods User',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'name' => '商品名称',
            'desc' => '描述',
            'photo' => '产品图片',
            'price' => '价格',
            'stock' => '库存',
            'address' => '地址',
            'mobile' => '电话',
            'qq' => 'QQ',
            'weixin' => '微信',
            'email' => '邮箱',
            'lng' => 'Lng',
            'lat' => 'Lat',
            'unit' => '单位',
            'end_time' => '下架时间',
        ];
    }
}
