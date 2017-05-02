<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "appeal".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $orderid
 * @property integer $type
 * @property string $orderno
 * @property integer $result
 * @property string $remark
 * @property string $reason
 * @property integer $created_at
 * @property integer $updated_at
 */
class Appeal extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appeal';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderid', 'type', 'result', 'created_at', 'updated_at'], 'integer'],
            [['reason'], 'string'],
            [['user_guid'], 'string', 'max' => 64],
            [['orderno'], 'string', 'max' => 255],
            [['remark'], 'string', 'max' => 1024]
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
            'type' => '申诉类型',
            'orderno' => '订单编号',
            'result' => '处理结果',
            'remark' => '处理意见',
            'reason' => '申诉原因',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getUser(){
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
}
