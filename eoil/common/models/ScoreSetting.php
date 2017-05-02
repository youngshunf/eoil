<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "score_setting".
 *
 * @property integer $id
 * @property string $type
 * @property double $score
 * @property string $desc
 * @property integer $created_at
 */
class ScoreSetting extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'score_setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['score'], 'number'],
            [['created_at'], 'integer'],
            [['type'], 'string', 'max' => 64],
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
            'type' => '类型',
            'score' => '积分',
            'desc' => '描述',
            'created_at' => '创建时间',
        ];
    }
}
