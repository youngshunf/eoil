<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_invite".
 *
 * @property integer $id
 * @property string $user_guid
 * @property string $invite_user
 * @property integer $created_at
 */
class UserInvite extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_invite';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at'], 'integer'],
            [['user_guid', 'invite_user'], 'string', 'max' => 48]
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
            'invite_user' => 'Invite User',
            'created_at' => 'Created At',
        ];
    }
}
