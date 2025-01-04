<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discountrequest".
 *
 * @property int $id
 * @property int $customer_id
 * @property int $discount_rate
 * @property int $p_n
 */
class Discountrequest extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'discountrequest';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'customer_id', 'discount_rate', 'p_n'], 'required'],
            [['id', 'customer_id', 'discount_rate', 'p_n'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'customer_id' => 'مشتری',
            'discount_rate' => 'درصد تخفیف',
            'p_n' => 'افزایش/ کاهش',
        ];
    }
}
