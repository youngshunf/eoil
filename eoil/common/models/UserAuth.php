<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_auth".
 *
 * @property integer $id
 * @property string $user_guid
 * @property integer $uid
 * @property integer $user_type
 * @property string $name
 * @property string $id_code
 * @property string $id_photo1
 * @property string $id_photo2
 * @property string $id_photo3
 * @property string $company_name
 * @property string $company_owner
 * @property string $owner_code
 * @property string $company_credit_code
 * @property string $org_code
 * @property string $business_license
 * @property string $tax_reg
 * @property string $org_cert
 * @property integer $auth_result
 * @property string $auth_remark
 * @property string $auth_user
 * @property integer $auth_time
 */
class UserAuth extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_auth';
    }

    /**
     * @inheritdoc
     */
//     public function rules()
//     {
//         return [
//             [['uid', 'user_type', 'auth_result', 'auth_time'], 'integer'],
//             [['user_guid'], 'string', 'max' => 48],
//             [['name', 'id_code'], 'string', 'max' => 20],
//             [['id_photo1', 'id_photo2', 'id_photo3', 'org_cert', 'auth_remark', 'auth_user'], 'string', 'max' => 255],
//             [['company_name', 'company_owner', 'company_credit_code', 'org_code', 'business_license', 'tax_reg'], 'string', 'max' => 40],
//             [['owner_code'], 'string', 'max' => 30]
//         ];
//     }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_guid' => '用户ID',
            'uid' => 'Uid',
            'user_type' => '认证类型',
            'name' => '姓名',
            'id_code' => '身份证号',
            'id_photo1' => '身份证正面照',
            'id_photo2' => '身份证反面照',
            'id_photo3' => '手持身份证照片',
            'company_name' => '公司名称',
            'company_owner' => '公司法人',
            'owner_code' => '法人身份证',
            'company_credit_code' => '社会信用代码',
            'org_code' => '组织机构代码',
            'business_license' => '营业执照',
            'tax_reg' => '税务登记证',
            'org_cert' => '组织机构证',
            'auth_result' => '审核结果',
            'auth_remark' => '审核意见',
            'auth_user' => '审核用户',
            'auth_time' => '审核时间',
        ];
    }
    
    public function getUser(){
        return $this->hasOne(User::className(), ['user_guid'=>'user_guid']);
    }
}
