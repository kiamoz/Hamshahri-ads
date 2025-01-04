<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer_duration".
 *
 * @property int $id
 * @property int $kargozar_id
 * @property int $customer_id
 * @property string $name_customer
 * @property string $date
 */
class CustomerDuration extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'customer_duration';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['kargozar_id', 'customer_id'], 'integer'],
            [['name_customer', 'date'], 'required'],
            [['date'], 'safe'],
            [['name_customer'], 'string', 'max' => 2000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'kargozar_id' => 'Kargozar ID',
            'customer_id' => 'Customer ID',
            'name_customer' => 'Name Customer',
            'date' => 'Date',
        ];
    }
}
