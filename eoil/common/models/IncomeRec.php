<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "income_rec".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $orderid
 * @property string $orderno
 * @property string $refer_user
 * @property integer $number
 * @property string $refer_goods
 * @property integer $cateid
 * @property integer $agent_level
 * @property string $amount
 * @property integer $status
 * @property string $remark
 * @property string $year
 * @property string $year_month
 * @property string $year_month_day
 * @property integer $created_at
 * @property integer $updated_at
 */
class IncomeRec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'income_rec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderid', 'number', 'status', 'created_at', 'updated_at'], 'integer'],
            [['amount'], 'number'],
            [['user_guid'], 'string', 'max' => 48],
            [['orderno'], 'string', 'max' => 128],
            [['remark'], 'string', 'max' => 1024],
            [['year', 'year_month', 'year_month_day'], 'string', 'max' => 20]
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
            'orderid' => 'Orderid',
            'orderno' => 'Orderno',
            'refer_user' => 'Refer User',
            'number' => '数量',
            'refer_goods' => '相关产品',
            'cateid' => 'Cateid',
            'agent_level' => '代理级别',
            'amount' => '收入',
            'status' => '状态',
            'remark' => '备注',
            'year' => 'Year',
            'year_month' => 'Year Month',
            'year_month_day' => 'Year Month Day',
            'created_at' => '创建时间',
            'updated_at' => '修改时间',
        ];
    }
    
    public function getUser() {
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
}
