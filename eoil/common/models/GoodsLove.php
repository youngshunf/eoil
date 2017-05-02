<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_love".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $goods_id
 * @property integer $created_at
 */
class GoodsLove extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_love';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodsid', 'created_at'], 'integer'],
            [['user_guid'], 'string', 'max' => 255]
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
            'goods_id' => 'Goods ID',
            'created_at' => 'Created At',
        ];
    }
    public function getGoods(){
        return $this->hasOne(Goods::className(), ['id'=>'goodsid']);
    }
}
