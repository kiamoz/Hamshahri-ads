<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "task".
 *
 * @property int $id
 * @property int $user_id
 * @property string $time
 * @property int $status
 * @property int $ad_id
 */
class Task extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public $filedoc;
    public $ad;
    public $status_task;

    const status_task = array(
        1 => 'تمام شده',
        0 => 'نا تمام',
    );

    public static function tableName() {
        return 'task';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
                [['status', 'model_id'], 'required'],
                [['user_id', 'status', 'model_id'], 'integer'],
                [['time', 'filedoc','subject'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'user_id' => 'کاربر',
            'time' => 'زمان',
            'status' => 'وضعیت تسک',
            'model_id' => 'شناسه آگهی',
            'end_time' => 'زمان پایان',
            'start_time' => 'زمان شروع',
            'title' => 'عنوان آگهی',
            
        ];
    }

    public function getAd2() {
        return $this->hasOne(Ad::className(), ['id' => 'model_id']);
    }

    public static function limitword($string, $limit) {
        $words = explode(" ", $string);
        $output = implode(" ", array_splice($words, 0, $limit));
        return $output;
    }

}
