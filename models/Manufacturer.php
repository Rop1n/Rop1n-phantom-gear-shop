<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "manufacturer".
 *
 * @property int $id
 * @property string $name
 *
 * @property CategoryManufacturer[] $categoryManufacturers
 * @property Product[] $products
 */
class Manufacturer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'manufacturer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 100],
            [['name'], 'unique'],
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
     * Gets query for [[CategoryManufacturers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryManufacturers()
    {
        return $this->hasMany(CategoryManufacturer::class, ['manufacturer_id' => 'id']);
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['manufacturer_id' => 'id']);
    }
}
