<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "document".
 *
 * @property int $id
 * @property string $document
 * @property int $customer_id
 * @property string $file
 */
class Document extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'document';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['subject', 'customer_id', 'file','ad_id','customer_id','type','file_doc'], 'safe'],
            [['customer_id'], 'integer'],
            [['subject', 'file'], 'string', 'max' => 10000],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'document' => 'Document',
            'customer_id' => 'Customer ID',
            'file' => 'فایل پیوست',
            'file_doc' => ' پیوست',
            'subject'=>'موضوع'
        ];
    }
    public static function limitword($string, $limit) {
        $words = explode(" ", $string);
        $output = implode(" ", array_splice($words, 0, $limit));
        return $output;
    }
}
