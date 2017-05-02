<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_data".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $dtype
 * @property integer $jtype
 * @property string $name
 * @property integer $sex
 * @property double $tall
 * @property double $weight
 * @property integer $age
 * @property string $birthday
 * @property string $post
 * @property integer $sense
 * @property integer $straight
 * @property integer $movement
 * @property integer $cold_warm
 * @property integer $lightness
 * @property integer $purity
 * @property integer $shape
 * @property integer $skin_color
 * @property integer $style
 * @property string $path1
 * @property string $photo1
 * @property string $path2
 * @property string $photo2
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $updated_by
 */
class UserData extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_data';
    }

    /**
     * @inheritdoc
     */
//     public function rules()
//     {
//         return [
//             [['dtype', 'jtype', 'sex', 'age', 'sense', 'straight', 'movement', 'cold_warm', 'lightness', 'purity', 'shape', 'skin_color', 'style', 'created_at', 'updated_at'], 'integer'],
//             [['tall', 'weight'], 'number'],
//             [['user_guid', 'name', 'birthday', 'post', 'path1', 'photo1', 'path2', 'photo2', 'updated_by'], 'string', 'max' => 255]
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
            'dtype' => '数据类型',
            'jtype' => '诊断类型',
            'name' => '姓名',
            'sex' => '性别',
            'tall' => '身高',
            'weight' => '体重',
            'age' => '年龄',
            'birthday' => '生日',
            'post' => '职业',
            'sense' => '量感',
            'straight' => '直曲',
            'movement' => '动静',
            'cold_warm' => '冷暖',
            'lightness' => '明度',
            'purity' => '纯度',
            'shape' => '体型',
            'skin_color' => '肤色',
            'style' => '期望风格',
            'path1' => 'Path1',
            'photo1' => 'Photo1',
            'path2' => 'Path2',
            'photo2' => 'Photo2',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'updated_by' => '更新人',
        ];
    }
}
