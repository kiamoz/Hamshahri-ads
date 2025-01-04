<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "request".
 *
 * @property int $id
 * @property string $benefit
 * @property int $user_id
 */
class Request extends \yii\db\ActiveRecord
{
        public $file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'request';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'benefit', 'user_id','attach'], 'safe'],
            [['id', 'user_id'], 'integer'],
            [['benefit'], 'string', 'max' => 200],
            [['id'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'benefit' => 'مبلغ کارمزد درخواستی',
            'user_id' => 'کارگذار',
            'status'=>'وضعیت درخواست',
            'file'=>'فایل' 
            
        ];
    }
}
