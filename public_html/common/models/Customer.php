<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "customer".
 *
 * @property integer $id
 * @property string $name
 * @property integer $owner_id
 * @property integer $social_code
 * @property integer $addres
 * @property string $city
 * @property string $phone
 * @property string $postal_code
 */
class Customer extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    const type_id_text = array(
        7 => 'محصول فرهنگی',
        8 => 'محصول دانش بنیان ',
        9 => 'کشاورزی و صنایع دستی ',
        10 => 'گردشگری و اقامتی ',
        11 => 'گروه اول شامل گروه دوم ',
    );
    const customer_type = array(
        1 => 'حقیقی',
        2 => 'حقوقی ',
    );

    public static function tableName() {
        return 'customer';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name'], 'unique'],
            [['name','type'], 'required'],
            //[['name',], 'required','on'=>'create_f'],
            [['date', 'name', 'owner_id', 'city', 'social_code', 'phone', 'addres', 'economical_code', 'status', 'temp_p_n', 'discount_type', 'postal_code', 'takhfif', 'type_h', 'inc_khareji', 'state'], 'safe'],
            [['owner_id', 'social_code',], 'integer'],
            //[['name','status'], 'required'],
            [['name'], 'must_unique', 'on' => 'insret'],
//            [['box_qty'], 'must_less', 'on' => 'less'],
                //[['name', 'city', 'phone', 'postal_code'], 'string', 'max' => 200],
        ];
    }

    public function must_unique($attribute, $params) {
        $cust_table = Customer::find()->where(['name' => $this->name])->one();
//      print_r($cust_table);
//      exit();
        if ($cust_table) {
            $this->addError($attribute, 'نام تکراری است');
            return false;
        } else {
            return true;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'شناسه',
            'discount_type' => 'مدل تخفیف',
            'type'=>'حقیقی حقوقی',
            'name' => 'نام شخص یا شرکت',
            'owner_id' => 'کارگزار',
            'social_code' => 'کد ملی / شناسه ملی',
            'addres' => 'آدرس',
            'city' => 'شهر',
            'phone' => 'تلفن',
            'postal_code' => 'کد پستی',
            'economical_code' => 'کد اقتصادی',
            'status' => 'وضعیت مشتری',
            'takhfif' => 'تخفیف',
            'temp_p_n' => '',
            'inc_khareji' => 'افزایش تعرفه خارجی'
        ];
    }

    public function getC() {
        return $this->hasOne(location::className(), ['id' => 'city']);
    }

    public function getCity0() {
        return $this->hasOne(location::className(), ['id' => 'city']);
    }

    public function getS() {
        return $this->hasOne(State::className(), ['id' => 'state']);
    }

}
