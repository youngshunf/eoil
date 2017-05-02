<?php

namespace common\models;

use Yii;
use backend\models\AdminUser;

/**
 * This is the model class for table "user_judge".
 *
 * @property integer $id
 * @property integer $data_id
 * @property string $user_guid
 * @property integer $dtype
 * @property integer $jtype
 * @property integer $sense
 * @property integer $straight
 * @property integer $movement
 * @property integer $cold_warm
 * @property integer $lightness
 * @property integer $purity
 * @property integer $shape
 * @property integer $skin_color
 * @property integer $style
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $updated_by
 */
class UserJudge extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_judge';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['data_id', 'dtype', 'jtype', 'sense', 'straight', 'movement', 'cold_warm', 'lightness', 'purity', 'shape', 'skin_color', 'style', 'created_at', 'updated_at'], 'integer'],
            [['user_guid', 'updated_by'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'data_id' => 'Data ID',
            'user_guid' => 'User Guid',
            'dtype' => '数据类型',
            'jtype' => '诊断类型',
            'sense' => '量感',
            'straight' => '直曲',
            'movement' => '动静',
            'cold_warm' => '冷暖',
            'lightness' => '明度',
            'purity' => '纯度',
            'shape' => '体型',
            'skin_color' => '肤色',
            'style' => '适合风格',
            'created_at' => '创建时间',
            'updated_at' => '更新时间',
            'updated_by' => '诊断人',
        ];
    }
    
    public function getJudger(){
        return $this->hasOne(AdminUser::className(), ['user_guid'=>'updated_by']);
    }
}
