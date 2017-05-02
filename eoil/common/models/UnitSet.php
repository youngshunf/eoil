<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "unit_set".
 *
 * @property integer $id
 * @property string $desc
 * @property integer $created_at
 */
class UnitSet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'unit_set';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'created_at'], 'integer'],
            [['desc'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'desc' => '单位',
            'created_at' => 'Created At',
        ];
    }
}
