<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sys_set".
 *
 * @property integer $id
 * @property integer $keep_expire
 * @property integer $withdraw_deposit
 */
class SysSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'sys_set';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['keep_expire', 'withdraw_deposit','deposit_rate','car_deposit_rate'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'keep_expire' => '申诉期限(天)',
            'withdraw_deposit' => '履约期限(天)',
            'deposit_rate'=>'普通商品保证金比例(%)',
            'car_deposit_rate'=>'油罐车保证金比例(%)'
        ];
    }
}
