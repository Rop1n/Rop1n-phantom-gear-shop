<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_manufacturer".
 *
 * @property int $id
 * @property int $category_id
 * @property int $manufacturer_id
 *
 * @property Category $category
 * @property Manufacturer $manufacturer
 */
class CategoryManufacturer extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_manufacturer';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'manufacturer_id'], 'required'],
            [['category_id', 'manufacturer_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['manufacturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manufacturer::class, 'targetAttribute' => ['manufacturer_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'category_id' => 'Category ID',
            'manufacturer_id' => 'Manufacturer ID',
        ];
    }

    /**
     * Gets query for [[Category]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id']);
    }

    /**
     * Gets query for [[Manufacturer]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getManufacturer()
    {
        return $this->hasOne(Manufacturer::class, ['id' => 'manufacturer_id']);
    }
}
