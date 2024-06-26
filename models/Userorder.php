<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "userorder".
 *
 * @property int $id
 * @property int $oneorder
 * @property int $user
 *
 * @property Oneorder $oneorder0
 * @property User[] $users
 */
class Userorder extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'userorder';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['oneorder', 'user'], 'required'],
            [['oneorder', 'user'], 'integer'],
            [['oneorder'], 'exist', 'skipOnError' => true, 'targetClass' => Oneorder::class, 'targetAttribute' => ['oneorder' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'oneorder' => 'Oneorder',
            'user' => 'User',
        ];
    }

    /**
     * Gets query for [[Oneorder0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getOneorder0()
    {
        return $this->hasOne(Oneorder::class, ['id' => 'oneorder']);
    }

    /**
     * Gets query for [[Users]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::class, ['orders' => 'id']);
    }
}
