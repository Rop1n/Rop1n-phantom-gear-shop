<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "category_filter".
 *
 * @property int $id
 * @property int $category_id
 * @property int $filter_id
 *
 * @property Category $category
 * @property Filter $filter
 */
class CategoryFilter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category_filter';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'filter_id'], 'required'],
            [['category_id', 'filter_id'], 'integer'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::class, 'targetAttribute' => ['category_id' => 'id']],
            [['filter_id'], 'exist', 'skipOnError' => true, 'targetClass' => Filter::class, 'targetAttribute' => ['filter_id' => 'id']],
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
            'filter_id' => 'Filter ID',
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
     * Gets query for [[Filter]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getFilter()
    {
        return $this->hasOne(Filter::class, ['id' => 'filter_id']);
    }
}
