<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productcharacteristic".
 *
 * @property int $id
 * @property int $productid
 * @property int $characteristic_value_id
 *
 * @property CharacteristicValue $characteristicValue
 * @property Product $product
 */
class Productcharacteristic extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productcharacteristic';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['productid', 'characteristic_value_id'], 'required'],
            [['productid', 'characteristic_value_id'], 'integer'],
            [['productid'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['productid' => 'id']],
            [['characteristic_value_id'], 'exist', 'skipOnError' => true, 'targetClass' => CharacteristicValue::class, 'targetAttribute' => ['characteristic_value_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'productid' => 'Productid',
            'characteristic_value_id' => 'Characteristic Value ID',
        ];
    }

    /**
     * Gets query for [[CharacteristicValue]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristicValue()
    {
        return $this->hasOne(CharacteristicValue::class, ['id' => 'characteristic_value_id']);
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'productid']);
    }
}
