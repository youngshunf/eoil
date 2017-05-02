<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_coupon".
 *
 * @property integer $id
 * @property string $user_guid
 * @property string $coupon
 * @property string $amount
 * @property string $lowereast
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class UserCoupon extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_coupon';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['amount', 'lowereast'], 'number'],
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['user_guid'], 'string', 'max' => 48],
            [['coupon'], 'string', 'max' => 255]
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
            'coupon' => '优惠券码',
            'amount' => '优惠券金额',
            'lowereast' => '使用门槛',
            'status' => 'Status',
            'created_at' => '获取时间',
            'updated_at' => '使用时间',
        ];
    }
}
