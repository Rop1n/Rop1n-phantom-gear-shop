<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property string $productsheader
 * @property string $img
 * @property string $fontsize
 *
 * @property Product[] $products
 */
class Category extends \yii\db\ActiveRecord
{
    public $imageFile;
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 30],
            [['imageFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, svg'],
            [['img'], 'string', 'max' => 200],
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            if ($this->imageFile) {
                $fileName = 'uploads/' . $this->imageFile->baseName . '.' . $this->imageFile->extension;
                $this->imageFile->saveAs($fileName);
                $this->img = '/' . $fileName;
            } else {
                if (!($this->imageFile)) {
                $this->imageFile = '/img/default.png';
               }
            }
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Название категории',
            'imageFile' => 'Картинка категории',
            'fontsize' => 'Fontsize',
        ];
    }

    /**
     * Gets query for [[Products]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::class, ['category' => 'id']);
    }
}
