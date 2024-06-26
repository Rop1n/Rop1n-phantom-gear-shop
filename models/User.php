<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $username
 * @property int|null $isadmin
 * @property string $password
 * @property string|null $fullname
 * @property string|null $phone
 * @property string|null $nickname
 * @property string|null $city
 * @property string|null $street
 * @property string|null $house
 * @property string|null $apartment
 * @property int|null $cart
 * @property int|null $orders
 *
 * @property Cart $cart0
 * @property Cart[] $carts
 * @property Userorder $orders0
 */
class User extends ActiveRecord implements IdentityInterface
{
    public $password_repeat;
    public $rules;
    public $hash = true;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['isadmin', 'cart', 'orders'], 'integer'],
            [['username', 'city', 'street'], 'string', 'max' => 50],
            [['password'], 'string', 'max' => 255],
            ['password_repeat', 'compare', 'compareAttribute' => 'password'],
            [['fullname'], 'string', 'max' => 40],
            [['phone', 'nickname'], 'string', 'max' => 25],
            [['house', 'apartment'], 'string', 'max' => 5],
            [['username'], 'unique'],
            [['cart'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::class, 'targetAttribute' => ['cart' => 'id']],
            [['orders'], 'exist', 'skipOnError' => true, 'targetClass' => Userorder::class, 'targetAttribute' => ['orders' => 'id']],
            ['rules', 'compare', 'compareValue' => '1', 'message' => 'Необходимо принять условия регистрации'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Логин',
            'isadmin' => 'Isadmin',
            'password' => 'Пароль',
            'password_repeat' => 'Повтор пароля',
            'fullname' => 'Имя',
            'phone' => 'Телефон',
            'nickname' => 'Ник',
            'city' => 'Город',
            'street' => 'Улица',
            'house' => 'Дом',
            'apartment' => 'Квартира',
            'rules' => 'Согласие на обработку персональных данных',
        ];
    }



    /**
     * Finds an identity by the given ID.
     *
     * @param string|int $id the ID to be looked for
     * @return IdentityInterface|null the identity object that matches the given ID.
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * Finds an identity by the given token.
     *
     * @param string $token the token to be looked for
     * @return IdentityInterface|null the identity object that matches the given token.
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return null;
    }

    /**
     * @return int|string current user ID
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return string current user auth key
     */
    public function getAuthKey()
    {
        return null;
    }

    /**
     * @param string $authKey
     * @return bool if auth key is valid for current user
     */
    public function validateAuthKey($authKey)
    {
        return false;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return User::findOne(['username' => $username]);
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function beforeSave($insert)
    {
        if($this->hash){
            $this->password = md5($this->password);
        }
        return parent::beforeSave($insert);
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['user_id' => 'id']);
    }

    /**
     * Gets query for [[Orders]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOrders()
    {
        return $this->hasMany(Order::class, ['user_id' => 'id']);
    }

    public function isAdmin(){
        return $this->isadmin;
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[static::SCENARIO_DEFAULT] = ['username', 'password', 'isadmin', 'orders', 'fullname', 'phone', 'nickname', 'city', 'street', 'house', 'apartment'];
        return $scenarios;
    }
}
