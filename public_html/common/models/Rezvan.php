<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "rezvan".
 *
 * @property int $id
 * @property int $ad_id
 * @property int $user_id
 * @property string $gallery
 */
class Rezvan extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'rezvan';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ad_id', 'user_id', 'gallery'], 'required'],
            [['ad_id', 'user_id'], 'integer'],
            [['gallery'], 'string', 'max' => 2000],
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
            'user_id' => 'شناسه کاربر',
            'gallery' => 'گالری',
        ];
    }
}
