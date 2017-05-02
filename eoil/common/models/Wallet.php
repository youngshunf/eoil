<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wallet".
 *
 * @property integer $id
 * @property string $user_guid
 * @property string $balance
 * @property string $paid
 * @property string $total_amount
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $withdrawing
 */
class Wallet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wallet';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'created_at', 'updated_at'], 'integer'],
            [['balance', 'paid', 'total_amount', 'withdrawing'], 'number'],
            [['user_guid'], 'string', 'max' => 36]
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
            'balance' => '余额',
            'paid' => '已提款',
            'total_amount' => '累计收益',
            'frozen'=>'冻结金额',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'withdrawing' => '提现中',
        ];
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
}
