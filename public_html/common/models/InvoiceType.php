<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "invoice_type".
 *
 * @property int $id
 * @property string $ad_type
 * @property string $account_number
 * @property string $number_of_card_title
 * @property string $pages
 * @property string $andazegiri
 */
class InvoiceType extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'invoice_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ad_type', 'account_number', 'number_of_card_title', 'pages', 'andazegiri','shaba','phone_number','phone_number','address'], 'string', 'max' => 2000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ad_type' => 'نوع آگهی ',
            'account_number' => 'شماره حساب',
            'number_of_card_title' => 'عنوان تعداد کادر',
            'pages' => 'صفحه',
            'andazegiri' => 'واحد اندازه گیری',
            'phone_number'=>'شماره تلفن',
            'address'=>'آدرس',
        ];
    }

}
