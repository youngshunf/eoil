<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "appeal_photo".
 *
 * @property integer $id
 * @property integer $appealid
 * @property string $path
 * @property string $photo
 * @property string $created_at
 */
class AppealPhoto extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'appeal_photo';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appealid'], 'integer'],
            [['path', 'photo', 'created_at'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'appealid' => 'Appealid',
            'path' => 'Path',
            'photo' => 'Photo',
            'created_at' => 'Created At',
        ];
    }
}
