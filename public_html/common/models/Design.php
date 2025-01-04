<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "design".
 *
 * @property int $id
 * @property int $ad_id
 * @property int $tarahi_id
 * @property string $attach
 * @property int $status
 * @property string $why_reject
 */
class Design extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public $file,$gallery;
    public static function tableName()
    {
        return 'design';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['ad_id', 'tarahi_id', 'attach', 'status', 'why_reject','date'], 'safe'],
            [['ad_id', 'tarahi_id', 'status'], 'integer'],
            [['attach', 'why_reject'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'ad_id' => 'شناسه آگهی',
            'tarahi_id' => 'طراح',
            'attach' => 'فایل پیوست',
            'status' => 'Status',
            'why_reject' => 'دلیل رد',
            'gallery'=>'گالری '
        ];
    }
}
