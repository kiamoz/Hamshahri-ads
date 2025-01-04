<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "box".
 *
 * @property int $id
 * @property string $name
 * @property string $price
 */
class Box extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'box';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'price'], 'required'],
            [['name', 'price'], 'string', 'max' => 200],
            [['price_sabti', 'price_dolati','price_nafti','price_tahator','price_sabti99','price_dolati99','price99','status','name_print'], 'safe'],
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
            'price' => 'Price',
            'name_print'=>'اسم کادر برای پرنیت فاکتور',
        ];
    }
}
