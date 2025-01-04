<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "contract".
 *
 * @property int $id
 * @property int $price
 * @property int $benefit_rate
 * @property int $customer_id
 * @property int $contract_number
 */
class Contract extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'contract';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
             [['status'], 'safe'],
            [['price', 'benefit_rate', 'customer_id', 'contract_number'], 'required'],
            [['price', 'benefit_rate', 'customer_id', 'contract_number'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'price' => 'قیمت',
            'benefit_rate' => 'درصد کارمزد',
            'customer_id' => 'نام مشتری',
            'contract_number' => 'شماره قرارداد',
            'status'=>'وضعیت',
        ];
    }
}
