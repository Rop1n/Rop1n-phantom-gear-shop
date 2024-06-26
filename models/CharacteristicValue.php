<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "characteristic_value".
 *
 * @property int $id
 * @property int $characteristic_id
 * @property string $value
 *
 * @property Characteristic $characteristic
 * @property Productcharacteristic[] $productcharacteristics
 */
class CharacteristicValue extends \yii\db\ActiveRecord
{
    public $characterictic_id_arr;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'characteristic_value';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['characteristic_id', 'product_id', 'value'], 'required'],
            [['characteristic_id', 'product_id'], 'integer'],
            [['value'], 'string', 'max' => 100],
            [['characteristic_id'], 'exist', 'skipOnError' => true, 'targetClass' => Characteristic::class, 'targetAttribute' => ['characteristic_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'characteristic_id' => 'Characteristic ID',
            'value' => 'Value',
        ];
    }

    /**
     * Gets query for [[Characteristic]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristic()
    {
        return $this->hasOne(Characteristic::class, ['id' => 'characteristic_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }
}
