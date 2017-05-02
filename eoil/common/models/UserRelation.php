<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_relation".
 *
 * @property integer $id
 * @property string $user_guid
 * @property string $parent_user
 * @property integer $created_at
 */
class UserRelation extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['user_guid', 'parent_user'], 'string', 'max' => 48]
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
            'parent_user' => 'Parent User',
            'created_at' => 'Created At',
        ];
    }
    
    public function getParent(){
        return $this->hasOne(User::className(), ['parent_user'=>'user_guid']);
    }
    
    public function getChild(){
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
}
