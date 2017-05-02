<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_score".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $score
 * @property string $desc
 * @property integer $type
 * @property string $created_at
 */
class UserScore extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_score';
    }

    /**
     * @inheritdoc
     */
//     public function rules()
//     {
// //         return [
// //             [['score', 'type'], 'integer'],
// //             [['user_guid'], 'string', 'max' => 48],
// //             [['desc', 'created_at'], 'string', 'max' => 255]
// //         ];
//     }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_guid' => 'User Guid',
            'score' => '积分',
            'desc' => '描述',
            'type' => '积分类型',
            'created_at' => 'Created At',
        ];
    }
    
    public function getScoreDesc($type){
        $arr=[
            'type.0'=>[
                'score'=>'5',
                'desc'=>'签到'
            ],
            'type.1'=>[
                'score'=>'10',
                'desc'=>'邀请好友'
            ],
            'type.2'=>[
                'score'=>'5',
                'desc'=>'喜欢商品'
            ],
            'type.3'=>[
                'score'=>'5',
                'desc'=>'加入购物车'
            ]
        ];
        
        return $arr['type'.$type];
        
    }
    
    
    public    function setScore($user,$type){
        $score=$this->getScoreDesc($type);
        $userScore=new UserScore();
        $userScore->user_guid=$user->user_guid;
        $userScore->type=$type;
        $userScore->score=$score['score'];
        $userScore->desc=$score['desc'];
        $userScore->created_at=time();
        if($userScore->save()){
            $scoreUser=User::findOne(['user_guid'=>$user->user_guid]);
            $scoreUser->score+=$userScore->score;
            $scoreUser->save();
            return $scoreUser;
        }
        return false;
    }
}
