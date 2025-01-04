<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_msg".
 *
 * @property int $id
 * @property int $ad_id
 * @property string $date
 * @property int $internal
 * @property int $task_id
 */
class AdMsg extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'ad_msg';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['ad_id', 'date', 'internal', 'task_id', 'date', 'user_id', 'msg', 'doc_cancel'], 'safe'],
            [['ad_id', 'internal', 'task_id'], 'integer'],
            [['date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'ad_id' => 'Ad ID',
            'date' => 'Date',
            'internal' => 'Internal',
            'task_id' => 'Task ID',
            'msg' => 'پیام',
            'user_id' => 'از طرف'
        ];
    }

}
