<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "orders".
 *
 * @property integer $id
 * @property string $user_guid
 * @property string $seller_user
 * @property string $orderno
 * @property integer $type
 * @property integer $goodsid
 * @property string $goods_price
 * @property integer $cateid
 * @property string $goods_name
 * @property string $balance_amount
 * @property string $amount
 * @property integer $number
 * @property string $withdraw_amount
 * @property string $pay_type
 * @property integer $is_pay
 * @property string $total_amount
 * @property integer $pay_time
 * @property integer $seller_confirm_time
 * @property integer $is_seller_confirm
 * @property integer $is_buyer_confirm
 * @property integer $break_uid
 * @property integer $deal_time
 * @property integer $break_time
 * @property integer $withdraw_time
 * @property integer $break_type
 * @property integer $cancel_uid
 * @property integer $cancel_type
 * @property integer $status
 * @property integer $buyer_confirm_time
 * @property integer $cancel_time
 * @property string $remark
 * @property string $year
 * @property string $year_month
 * @property string $year_month_day
 * @property integer $created_at
 * @property integer $updated_at
 */
class Orders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'orders';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'goodsid', 'cateid', 'number', 'is_pay', 'pay_time', 'seller_confirm_time', 'is_seller_confirm', 'is_buyer_confirm', 'break_uid', 'deal_time', 'break_time', 'withdraw_time', 'break_type', 'cancel_uid', 'cancel_type', 'status', 'buyer_confirm_time', 'cancel_time', 'created_at', 'updated_at'], 'integer'],
            [['goods_price', 'balance_amount', 'amount', 'withdraw_amount', 'total_amount'], 'number'],
            [['user_guid', 'seller_user', 'orderno'], 'string', 'max' => 48],
            [['goods_name', 'pay_type', 'remark', 'year', 'year_month', 'year_month_day'], 'string', 'max' => 255]
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
            'seller_user' => 'Seller User',
            'orderno' => '订单编号',
            'type' => '订单类型',
            'goodsid' => '商品ID',
            'goods_price' => '商品价格',
            'cateid' => '分类ID',
            'goods_name' => '商品名称',
            'balance_amount' => '余额支付金额',
            'amount' => '实际支付金额',
            'number' => '数量',
            'withdraw_amount' => 'Withdraw Amount',
            'pay_type' => '支付方式',
            'is_pay' => '是否支付',
            'total_amount' => '订单金额',
            'pay_time' => '供货商支付时间',
            'seller_confirm_time' => '供货商确认时间',
            'is_seller_confirm' => '供货商确认',
            'is_buyer_confirm' => '进货商确认',
            'break_uid' => 'Break Uid',
            'deal_time' => '成交时间',
            'break_time' => '违约时间',
            'withdraw_time' => 'Withdraw Time',
            'break_type' => '违约类型',
            'cancel_uid' => '取消用户',
            'cancel_type' => '取消类型',
            'status' => '订单状态',
            'buyer_confirm_time' => '进货商确认时间',
            'cancel_time' => '取消时间',
            'remark' => '备注',
            'year' => '订单年份',
            'year_month' => '订单月份',
            'year_month_day' => '订单日',
            'created_at' => '下单时间',
            'updated_at' => '更新时间',
        ];
    }
    
    public static function getOrderNo(){
        return  date('YmdHis').rand(1000,9999);
    }
    public static function getSellerOrderNo($orderno){
        return  rand(100,999).$orderno;
    }
    
    public function getUser() {
       return $this->hasOne(User::className(), ['user_guid'=>'user_guid']) ;
    }
    public function getGoods() {
        return $this->hasOne(Goods::className(), ['id'=>'goodsid']);
    }
    public function getSeller() {
       return $this->hasOne(User::className(), ['user_guid'=>'seller_user']) ;
    }
}
