<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "characteristic".
 *
 * @property int $id
 * @property string $name
 *
 * @property CharacteristicValue[] $characteristicValues
 */
class Characteristic extends \yii\db\ActiveRecord
{
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'characteristic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * Gets query for [[CharacteristicValues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristicValues()
    {
        return $this->hasMany(CharacteristicValue::class, ['characteristic_id' => 'id']);
    }
}
