<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "cartproduct".
 *
 * @property int $id
 * @property int $cart
 * @property int $product
 *
 * @property Cart $cart0
 * @property Cart[] $carts
 * @property Product $product0
 */
class Cartproduct extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'cartproduct';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cart', 'product'], 'required'],
            [['cart', 'product'], 'integer'],
            [['cart'], 'exist', 'skipOnError' => true, 'targetClass' => Cart::class, 'targetAttribute' => ['cart' => 'id']],
            [['product'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cart' => 'Cart',
            'product' => 'Product',
        ];
    }

    /**
     * Gets query for [[Cart0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCart0()
    {
        return $this->hasOne(Cart::class, ['id' => 'cart']);
    }

    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['products' => 'id']);
    }

    /**
     * Gets query for [[Product0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct0()
    {
        return $this->hasOne(Product::class, ['id' => 'product']);
    }
}
