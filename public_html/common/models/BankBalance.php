<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "bank_balance".
 *
 * @property int $id
 * @property string $cash
 * @property string $cheque
 * @property string $date
 */
class BankBalance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'bank_balance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['cash', 'cheque', 'date'], 'required'],
            [['date'], 'safe'],
            [['cash', 'cheque'], 'string', 'max' => 2000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'cash' => 'حواله',
            'cheque' => 'چک',
            'date' => 'تاریخ',
        ];
    }
}
