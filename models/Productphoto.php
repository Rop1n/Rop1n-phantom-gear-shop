<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "productphoto".
 *
 * @property int $id
 * @property int $productid
 * @property int $photoid
 *
 * @property Photo $photo
 * @property Product $product
 */
class Productphoto extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'productphoto';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'photo'], 'required'],
            [['product_id'], 'integer'],
            [['photo'], 'string', 'max' => 200]
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
            'photoid' => 'Photoid',
        ];
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
