<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "withdraw_rec".
 *
 * @property integer $id
 * @property string $uid
 * @property string $auth_user
 * @property string $amount
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class WithdrawRec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'withdraw_rec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['user_guid', 'auth_user'], 'string', 'max' => 36]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => '提现用户',
            'auth_user' => '审核用户',
            'amount' => '提现金额',
            'status' => '状态',
            'created_at' => '申请时间',
            'updated_at' => '更新时间',
        ];
    }
    public function getUser() {
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
}
