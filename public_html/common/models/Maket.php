<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "maket".
 *
 * @property int $box_id
 * @property int $date
 * @property string $maket
 */
class Maket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'maket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['box_id', 'date', 'maket','special_box_id','special_page_maket'], 'safe'],
            [['box_id', 'date'], 'integer'],
            [['maket'], 'string', 'max' => 2000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'box_id' => 'Box ID',
            'date' => 'Date',
            'maket' => 'Maket',
        ];
    }
}
