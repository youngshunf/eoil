<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_photo".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $uid
 * @property integer $goodsid
 * @property string $path
 * @property string $photo
 * @property integer $created_at
 */
class GoodsPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_photo';
    }

    /**
     * @inheritdoc
     */
//     public function rules()
//     {
//         return [
//             [['uid', 'goodsid', 'created_at'], 'integer'],
//             [['user_guid'], 'string', 'max' => 48],
//             [['path', 'photo'], 'string', 'max' => 64]
//         ];
//     }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_guid' => 'User Guid',
            'uid' => 'Uid',
            'goodsid' => 'Goodsid',
            'path' => 'Path',
            'photo' => 'Photo',
            'created_at' => 'Created At',
        ];
    }
}
