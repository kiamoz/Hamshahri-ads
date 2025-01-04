<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "vat_year".
 *
 * @property int $id
 * @property int $year >= این سال بود
 * @property string $vat_percent
 */
class VatYear extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'vat_year';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['year', 'vat_percent'], 'required'],
            [['year'], 'integer'],
            [['vat_percent'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'شناسه',
            'year' => 'سال و سال های بعد',
            'vat_percent' => 'درصد ارزش افزوده',
        ];
    }
    public static function get_vat_year(){

        return VatYear::find()->orderBY(['id'=>SORT_DESC])->all();


    }

    public static function vatfinder($model){

        if($model->date)
        return self::get_vat($model->date, \Yii::$app->params['vat']);

    }

    public static function get_vat($date,$data){

        $p_date = Persian::convert_date_to_fa($date);
        $p_year = explode("/",$p_date)[0];

        foreach($data as $year){

            if($p_year >= $year->year)
                return $year->vat_percent/100;


        }

    }
}
