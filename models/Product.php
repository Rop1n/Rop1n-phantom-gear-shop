<?php

namespace app\models;

use yii\web\UploadedFile;
use yii\helpers\FileHelper;

use Yii;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property int $multicolor
 * @property string $name
 * @property float $price
 * @property string $preview
 * @property string $descriptionShort
 * @property string $descriptionMore
 * @property int $category
 * @property int|null $photos
 * @property int $versions
 *
 * @property Cartproduct[] $cartproducts
 * @property Category $category0
 * @property Orderproduct[] $orderproduct
 * @property Productcharacteristic[] $productcharacteristics
 * @property Productphoto[] $productphotos
 * @property Versionproduct[] $versionproducts
 */
class Product extends \yii\db\ActiveRecord
{

    public $previewFile;
    public $imageFiles;

    public static function tableName()
    {
        return 'product';
    }

    public function rules()
    {
        return [
            [['name', 'price', 'descriptionShort', 'descriptionMore', 'category'], 'required'],
            [['price'], 'number'],
            [['descriptionShort', 'descriptionMore'], 'string'],
            [['category', 'manufacturer_id', 'is_new'], 'integer'],
            [['name', 'preview'], 'string', 'max' => 200],
            [['previewFile'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg'],
            [['imageFiles'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg, jpeg', 'maxFiles' => 10],
            [['characteristics', 'characteristicValues'], 'safe'],
            [['manufacturer_id'], 'exist', 'skipOnError' => true, 'targetClass' => Manufacturer::class, 'targetAttribute' => ['manufacturer_id' => 'id']],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'price' => 'Стоимость',
            'preview' => 'Обложка товара',
            'previewFile' => 'Обложка товара',
            'imageFiles' => 'Фотографии товара',
            'descriptionShort' => 'Короткое описание',
            'descriptionMore' => 'Длинное описание (продолжение)',
            'category' => 'Категория',
            'photos' => 'Photos',
            'manufacturer_id' => 'Производитель',
            'is_new' => 'Реклама',
        ];
    }

    private function generateUniqueFileName(UploadedFile $file)
    {
        return Yii::$app->security->generateRandomString(8).'.'.$file->extension;
    }


    public function uploadPreview()
    {
        if ($this->previewFile) {
            $fileName = 'uploads/' . $this->generateUniqueFileName($this->previewFile);
            $this->previewFile->saveAs($fileName);
            $this->preview = "/" . $fileName;
            return true;
        }
        return false;
    }

    public function uploadFiles()
    {
        $filePaths = [];
        foreach ($this->imageFiles as $file) {
            $uploadPath = Yii::getAlias('@webroot/uploads/');
            if (!file_exists($uploadPath)) {
                mkdir($uploadPath, 0777, true);
            }

            $uniqueName = $this->generateUniqueFileName($file);
            $filePath = $uploadPath . $uniqueName;

            if ($file->saveAs($filePath)) {
                $filePaths[] = '/uploads/' . $uniqueName;
            }
        }
        return $filePaths;
    }

    public function deleteOldPreview()
    {
        if ($this->preview && file_exists(Yii::getAlias('@webroot') . $this->preview)) {
            unlink(Yii::getAlias('@webroot') . $this->preview);
        }
    }

    public function deleteOldPhotos()
    {
        $photos = ProductPhoto::findAll(['product_id' => $this->id]);
        foreach ($photos as $photo) {
            if (file_exists(Yii::getAlias('@webroot') . $photo->photo)) {
                unlink(Yii::getAlias('@webroot') . $photo->photo);
            }
        }
    }




    /**
     * Gets query for [[Carts]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCarts()
    {
        return $this->hasMany(Cart::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[Category0]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory0()
    {
        return $this->hasOne(Category::class, ['id' => 'category']);
    }
    public function getManufacturer()
    {
        return $this->hasOne(Manufacturer::class, ['id' => 'manufacturer_id']);
    }

    public function getOrderproducts()
    {
        return $this->hasMany(Orderproduct::class, ['product' => 'id']);
    }


    public function getProductphotos()
    {
        return $this->hasMany(Productphoto::class, ['product_id' => 'id']);
    }

    /**
     * Gets query for [[CharacteristicValues]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCharacteristicValues()
    {
        return $this->hasMany(CharacteristicValue::class, ['product_id' => 'id']);
    }

    public function isInCart()
    {
        return Cart::find()->where(['product_id' => $this->id, 'user_id' => Yii::$app->user->id])->exists();
    }
}
