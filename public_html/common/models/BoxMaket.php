<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "box_maket".
 *
 * @property int $id
 * @property string $name
 * @property string $price
 * @property string $price_nafti
 * @property string $price_sabti
 * @property string $price_dolati
 */
class BoxMaket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'box_maket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [[ 'name', 'price', 'price_nafti', 'price_sabti', 'price_dolati'], 'required'],
           
            [['name', 'price', 'price_nafti', 'price_sabti', 'price_dolati'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'name' => 'نام',
            'price' => 'قیمت',
            'price_nafti' => 'قیمت برای آگهی نفتی',
            'price_sabti' => 'قیمت برای آگهی ثبتی',
            'price_dolati' => 'قیمت برای آگهی دولتی',
        ];
    }
}
