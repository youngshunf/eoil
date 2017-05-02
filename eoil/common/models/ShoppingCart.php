<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "shopping_cart".
 *
 * @property integer $id
 * @property string $uid
 * @property integer $goodsid
 * @property integer $status
 * @property integer $count
 * @property integer $created_at
 * @property integer $updated_at
 */
class ShoppingCart extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'shopping_cart';
    }

    /**
     * @inheritdoc
     */
//     public function rules()
//     {
//         return [
//             [['goodsid', 'status', 'count', 'created_at', 'updated_at'], 'integer'],
//             [['uid'], 'string', 'max' => 255]
//         ];
//     }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'uid' => 'Uid',
            'goodsid' => 'Goodsid',
            'status' => 'Status',
            'count' => '数量',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
    public function getGoods(){
        return $this->hasOne(Goods::className(), ['id'=>'goodsid']);
    }
}
