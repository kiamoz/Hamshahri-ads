<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "reject".
 *
 * @property int $id
 * @property int $ad_id
 * @property int $dabiri_id
 * @property int $paziresh_id
 * @property string $gallery
 */
class Reject extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reject';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ad_id', 'dabiri_id', 'paziresh_id','reseller_id','status'], 'integer'],
            [['gallery'], 'string', 'max' => 2000],
            [['text'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'ad_id' => 'شناسه آگهی',
            'dabiri_id' => 'شناسه دبیری',
            'paziresh_id' => 'شناسه پذیرش',
            'gallery' => 'گالری',
             'status' => 'وضعیت',
            'text'=>'متن',
        ];
    }
}
