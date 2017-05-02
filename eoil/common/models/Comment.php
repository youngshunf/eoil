<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "comment".
 *
 * @property integer $id
 * @property integer $goodsid
 * @property integer $user_guid
 * @property string $content
 * @property string $score
 * @property string $created_at
 * @property integer $orderid
 */
class Comment extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'comment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['goodsid', 'user_guid', 'orderid'], 'integer'],
            [['score'], 'number'],
            [['content', 'created_at'], 'string', 'max' => 255]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'goodsid' => 'Goodsid',
            'user_guid' => 'User Guid',
            'content' => '评论内容',
            'score' => 'Score',
            'created_at' => 'Created At',
            'orderid' => 'Orderid',
        ];
    }
}
