<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wx_enterprise_pay".
 *
 * @property integer $id
 * @property string $user_guid
 * @property string $openid
 * @property string $partner_trade_no
 * @property string $payment_no
 * @property string $payment_time
 * @property integer $created_at
 */
class WxEnterprisePay extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wx_enterprise_pay';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['user_guid', 'openid'], 'string', 'max' => 48],
            [['partner_trade_no', 'payment_no', 'payment_time'], 'string', 'max' => 128]
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
            'openid' => 'Openid',
            'partner_trade_no' => 'Partner Trade No',
            'payment_no' => 'Payment No',
            'payment_time' => 'Payment Time',
            'created_at' => 'Created At',
        ];
    }
}
