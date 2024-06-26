<?php
namespace app\models;

use yii\base\Model;
use app\models\User;
use Yii;

class ProfileForm extends Model
{
    public $name;
    public $phone;
    public $username;
    public $nickname;
    public $city;
    public $street;
    public $house;
    public $apartment;
    public $hash = false;

    public function rules()
    {
        return [
            [['name', 'phone', 'username', 'nickname', 'city', 'street', 'house', 'apartment'], 'safe'],
            [['city', 'street', 'house', 'apartment', 'phone'], 'required', 'message' => 'Поле не может быть пустым.'],
            [['username'], 'required', 'message' => 'Логин не может быть пустым.'],
            [['username'], 'string', 'min' => 4, 'tooShort' => 'Логин должен быть не менее 4 символов.'],
            [['username', 'phone'], 'validateUniqueAttributes'],
            [['phone'], 'string', 'max' => 25],
            [['phone'], 'match', 'pattern' => '/^[\d+\-]{10,15}$/', 'message' => 'Телефон должен содержать от 10 до 15 символов и может включать только цифры, плюс и тире.'],
            
            [['username', 'city', 'street'], 'string', 'max' => 50],
            [['nickname'], 'string', 'max' => 25],
            [['house', 'apartment'], 'string', 'max' => 5],
        ];
    }

    public function validateUniqueAttributes($attribute, $params)
    {
        if ($attribute == 'username') {
            $user = User::find()->where(['username' => $this->username])->one();
            if ($user && $user->id != Yii::$app->user->id) {
                $this->addError('username', 'Этот логин уже занят.');
            }
        }

        if ($attribute == 'phone') {
            $user = User::find()->where(['phone' => $this->phone])->one();
            if ($user && $user->id != Yii::$app->user->id) {
                $this->addError('phone', 'Этот номер телефона уже используется.');
            }
        }
    }


    public function loadData($user)
    {
        $this->name = $user->fullname;
        $this->phone = $user->phone;
        $this->username = $user->username;
        $this->nickname = $user->nickname;
        $this->city = $user->city;
        $this->street = $user->street;
        $this->house = $user->house;
        $this->apartment = $user->apartment;
    }

    public function saveData($user)
    {
        $user->fullname = $this->name;
        $user->phone = $this->phone;
        $user->username = $this->username;
        $user->nickname = $this->nickname;
        $user->city = $this->city;
        $user->street = $this->street;
        $user->house = $this->house;
        $user->apartment = $this->apartment;
        $user->hash = $this->hash;
        return $user->save(false);
    }

    public function attributeLabels()
    {
        return [
            'name' => 'Имя',
            'phone' => 'Телефон',
            'username' => 'Логин',
            'nickname' => 'Никнейм',
            'city' => 'Город',
            'street' => 'Улица',
            'house' => 'Дом',
            'apartment' => 'Квартира',
        ];
    }


}
