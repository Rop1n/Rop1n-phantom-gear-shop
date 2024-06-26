<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "filter".
 *
 * @property int $id
 * @property string $name
 *
 * @property CategoryFilter[] $categoryFilters
 */
class Filter extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'filter';
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
     * Gets query for [[CategoryFilters]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategoryFilters()
    {
        return $this->hasMany(CategoryFilter::class, ['filter_id' => 'id']);
    }
}
