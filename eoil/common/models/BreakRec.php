<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "break_rec".
 *
 * @property integer $id
 * @property integer $orderid
 * @property integer $uid
 * @property string $path
 * @property string $photo
 * @property string $remark
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 */
class BreakRec extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'break_rec';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['orderid', 'uid', 'status', 'created_at', 'updated_at'], 'integer'],
            [['path', 'photo', 'remark'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'orderid' => 'Orderid',
            'uid' => 'Uid',
            'path' => 'Path',
            'photo' => 'Photo',
            'remark' => '备注',
            'status' => '状态',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
