<?php

namespace common\models;

use Yii;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $openid
 * @property string $user_guid
 * @property string $username
 * @property string $access_token
 * @property string $auth_key
 * @property string $password
 * @property string $password_origin
 * @property string $password_hash
 * @property integer $role_id
 * @property string $name
 * @property string $id_code
 * @property string $nick
 * @property string $city
 * @property string $province
 * @property string $country
 * @property string $address
 * @property string $company_address
 * @property string $home_address
 * @property string $path
 * @property integer $is_judge
 * @property string $photo
 * @property string $img_path
 * @property string $mobile
 * @property integer $mobile_auth
 * @property string $email
 * @property string $district
 * @property integer $email_auth
 * @property integer $isenable
 * @property string $last_ip
 * @property integer $last_time
 * @property string $imsi
 * @property string $imei
 * @property integer $created_at
 * @property integer $updated_at
 */
class User extends \yii\db\ActiveRecord implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'email_auth', 'isenable', 'last_time', 'created_at', 'updated_at'], 'integer'],
            [['openid', 'user_guid', 'password', 'email'], 'string', 'max' => 48],
            [['username', 'access_token', 'auth_key', 'name',  'district'], 'string', 'max' => 64],
            [['password_origin', 'imsi', 'imei'], 'string', 'max' => 255],
            [['password_hash', 'city', 'province', 'country', 'address', 'path', 'photo'], 'string', 'max' => 128],
            [['id_code'], 'string', 'max' => 32],
            [['company_address', 'home_address', 'img_path'], 'string', 'max' => 256],
            [['mobile', 'last_ip'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => '自增id',
            'openid' => '微信id',
            'user_guid' => '用户GUID',
            'username' => '用户名',
            'access_token' => 'Access Token',
            'auth_key' => 'auth_key',
            'password' => '密码',
            'password_origin' => 'Password Origin',
            'password_hash' => 'Password Hash',
            'role_id' => '用户角色:1-普通用户;2-高级用户;3-VIP用户',
            'name' => '真实姓名',
            'id_code' => '身份证号',
            'nick' => '昵称',
            'city' => '城市',
            'province' => '份省',
            'country' => '国家',
            'address' => '地址',
            'company_address' => 'Company Address',
            'home_address' => 'Home Address',
            'path' => '头像',
            'is_auth' => '是否验证',
            'photo' => 'Photo',
            'img_path' => '微信头像',
            'mobile' => '手机',
            'mobile_auth' => '手机验证:0-未验证;1-已验证',
            'email' => '邮箱',
            'district' => '大区',
            'email_auth' => '邮箱验证:0-未验证;1-已验证',
            'isenable' => '账号是否启用:0-禁用;1-启用',
            'last_ip' => '最后登录IP',
            'last_time' => '最后登录时间',
            'imsi' => 'Imsi',
            'imei' => 'Imei',
            'created_at' => '注册时间',
            'updated_at' => '更新时间',
            'alipay'=>'支付宝'
        ];
    }
    
    public function generateAccessToken()
    {
        $this->access_token = Yii::$app->security->generateRandomString() . '_' . time();
    }
    
  /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username,$password)
    {
    	return static::find()->where("password='$password' AND(username='$username' OR email='$username' OR mobile='$username')")
    	->one();
       // return static::findOne(['username' => $username,'password'=>md5($password)]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }
}
