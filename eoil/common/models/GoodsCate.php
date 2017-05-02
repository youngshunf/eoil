<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "goods_cate".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $uid
 * @property integer $parentid
 * @property string $name
 * @property string $desc
 * @property string $path
 * @property string $photo
 * @property integer $count_goods
 * @property integer $created_at
 * @property integer $updated_at
 */
class GoodsCate extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'goods_cate';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['uid', 'parentid', 'count_goods', 'created_at', 'updated_at','is_car'], 'integer'],
            [['desc'], 'string'],
            [['user_guid'], 'string', 'max' => 48],
            [['name'], 'string', 'max' => 255],
            [['path', 'photo'], 'string', 'max' => 64]
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
            'uid' => 'Uid',
            'parentid' => '上级分类',
            'name' => '分类名',
            'desc' => '分类描述',
            'path' => 'Path',
            'photo' => 'Photo',
            'count_goods' => '产品数量',
            'created_at' => '创建时间',
            'updated_at' => 'Updated At',
        ];
    }
}
