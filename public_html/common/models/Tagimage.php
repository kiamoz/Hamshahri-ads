<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "tagimage".
 *
 * @property int $id
 * @property string $position
 * @property string $text
 */
class Tagimage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'tagimage';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['data', 'text'], 'required'],
            [['ad_id','file','user_id'], 'safe'],
            [['data'], 'string', 'max' => 20000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'position' => 'Position',
            'text' => 'Text',
        ];
    }
}
