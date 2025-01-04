<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "transition".
 *
 * @property int $id
 * @property string $date
 * @property int $amount
 * @property int $user_id
 * @property int $ad_id
 * @property string $type
 * @property int $etebar
 * @property int $actor_id
 */
class Transition extends \yii\db\ActiveRecord {

    /**
     * {@inheritdoc}
     */
    public static function tableName() {
        return 'transition';
    }

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['date', 'user_id', 'type', 'amount', 'sanad', 'resid','extra_info'], 'required'],
            [['date', 'bestankari', 'ad_id', 'detail', 'cheque_num', 'cheque_date', 'bank_id', 'branch', 'sanad', 'resid', 'priority_id', 'etebar'], 'safe'],
            [['user_id', 'ad_id', 'etebar', 'actor_id', 'amount', 'is_eslahi','extra_info','payment_date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels() {
        return [
            'id' => 'شناسه',
            'date' => 'تاریخ ثبت سند   ',
            'amount' => 'مبلغ  ',
            'user_id' => '  نام کارگزار',
            'is_eslahi' => 'سند اصلاحی',
            'type' => 'نوع',
            'ad_id' => 'شناسه آگهی',
            'etebar' => 'برای آگهی های اعتباری یا نقدی',
            'actor_id' => 'کاربر',
            'detail' => 'توضیحات',
            'cheque_num' => 'شماره چک',
            'cheque_date' => 'تاریخ چک',
            'bank_id' => 'بانک',
            'branch' => 'شعبه',
            'sanad' => 'سند مالی',
            'resid' => 'رسید صندوق',
            'balance_naghdi' => 'مانده نقدی',
            'balance_etebari' => 'مانده اعتباری',
            'priority_id' => 'اولویت تسویه بدهکاری با شماره فاکتور با ویرگول انگلیسی جدا کنید',
            'extra_info'=>'توضیحات',
            'payment_date'=>'تاریخ واریز به حساب '
        ];
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getBank() {
        return $this->hasOne(Bank::className(), ['id' => 'bank_id']);
    }

    public function getAd() {
        return $this->hasOne(Ad::className(), ['id' => 'ad_id']);
    }

    public static function get_live_balance($user_id, $naghdi_etebari) {
        $sum_ = 0;
        foreach (Ad::find()->where(['resseler_id' => $user_id, 'pay_status' => 0, 'naghdi_etebari' => $naghdi_etebari])->andWhere(['<>','status',-10])->all() as $ads_) {
            
            //echo $ads_->id;
            
             if ($ads_->vat)
                $ads_->in_amount *= (1+VatYear::vatfinder($ads_));

            $khales = 0;
            if ($ads_->naghdi_etebari == 1)
                $khales = ($ads_->in_amount - $ads_->benefit_price) - $ads_->cash;
            if ($ads_->naghdi_etebari == 2)
                $khales = ($ads_->in_amount) -  $ads_->cash;  // - $ads_->cash;


            $sum_ += $khales;
        }

        return $sum_;
    }

    public static function update_first_transction($ad_id, $amount, $user_id, $naghdi_etebari) {

        //echo "Hi";
        $ad_find = Ad::findOne($ad_id);
        $user = User::findOne($user_id);

        
        $old_one = Transition::find()->where(['ad_id' => $ad_id, 'type' => [1, 2, 3], 'user_id' => $user_id])->one();
        
       // echo Transition::find()->where(['ad_id' => $ad_id, 'type' => [1, 2, 3], 'user_id' => $user_id])->createCommand()->getRawSql();
        
       // echo $ad_id;

        $old_one_2 = Transition::find()->where(['ad_id' => $ad_id, 'type' => [1, 2, 3]])->andWhere(['<>', 'user_id', $user_id])->one();

        //echo "old_id:".$old_one->id." userid ".$user_id;
        //exit();
        //exit();
        
        //echo "X1";
        if ($old_one) {

            //echo "x2";

            //echo $old_one->id;

            self::revert_nghadi_etebari_user($user, $old_one->amount, $old_one->type);

            //echo $user->id."*";
            //exit();

            $old_one->delete();
            
            //print_r($old_one->getErrors());
        }

        if ($old_one_2) {
           // echo "x3";
            $user2 = User::findOne($old_one_2->user_id);
            self::revert_nghadi_etebari_user($user2, $old_one_2->amount, $old_one_2->type);
            $old_one_2->delete();
        }


        self::add_nghadi_etebari_user($user, $amount, $naghdi_etebari);

        $new_one = new Transition();
        $new_one->amount = $amount;
        $new_one->date = date('Y-m-d H:i:s');
        $new_one->auto_date = date('Y-m-d H:i:s');
        $new_one->ad_id = $ad_id;
        $new_one->detail = "[".$ad_find->custom_id . "]|" . $ad_find->customer->name;
        $new_one->balance_naghdi = self::get_live_balance($user_id, 1);
        $new_one->balance_etebari = self::get_live_balance($user_id, 2);
        $new_one->wallet = $user->wallet;
        $new_one->type = $naghdi_etebari;
        $new_one->user_id = $user_id;
        $new_one->save(false);

        //echo $new_one->type;
        //exit();
        //print_r($new_one->getErrors());
    }

    public static function add_nghadi_etebari_user($user, $amount, $naghdi_etebari) {

        //echo $naghdi_etebari." ".$user->credit_naghdi." ".$amount."<br>";

        if ($naghdi_etebari == 1) {
           // $user->credit_naghdi -= $amount;
        }
        if ($naghdi_etebari == 2) {
           // $user->credit -= $amount;
        }

        if ($naghdi_etebari == 3) {
            $user->credit_tahator -= $amount;
        }
        //echo $naghdi_etebari." ".$amount;
        $user->save();
        //print_r($user->getErrors());
    }

    public static function revert_nghadi_etebari_user($user, $amount, $naghdi_etebari, $ad_find = null) {

        //echo $user->id." ".$amount." ".$naghdi_etebari;
        //exit();



        if ($naghdi_etebari == 3) {
            $user->credit_tahator += $amount;
        }
        $user->save();
        //print_r($user->getErrors());
    }

    public static function convert_number($number) {

        $number = abs($number);

        $ones = array("", "یک", 'دو&nbsp;', "سه", "چهار", "پنج", "شش", "هفت", "هشت", "نه", "ده", "یازده", "دوازده", "سیزده", "چهارده", "پانزده", "شانزده", "هفده", "هجده", "نونزده");
        $tens = array("", "", "بیست", "سی", "چهل", "پنجاه", "شصت", "هفتاد", "هشتاد", "نود");
        $tows = array("", "صد", "دویست", "سیصد", "چهار صد", "پانصد", "ششصد", "هفتصد", "هشت صد", "نه صد");

        if (($number < 0) || ($number > 9999999999)) {
            throw new Exception("Number is out of range");
        }
        $Gm = floor($number / 1000000000);
        /* Millions (giga) */
        $number -= $Gm * 1000000000;
        
        $Gn = floor($number / 1000000);
        /* Millions (giga) */
        $number -= $Gn * 1000000;
        $kn = floor($number / 1000);
        /* Thousands (kilo) */
        $number -= $kn * 1000;
        $Hn = floor($number / 100);
        /* Hundreds (hecto) */
        $number -= $Hn * 100;
        $Dn = floor($number / 10);
        /* Tens (deca) */
        $n = $number % 10;
        /* Ones */
        $res = "";
        if ($Gm) {
            $res .= self::convert_number($Gm) . " میلیارد و ";
        }
        if ($Gn) {
            $res .= self::convert_number($Gn) . " میلیون و ";
        }
        if ($kn) {
            $res .= (empty($res) ? "" : " ") . self::convert_number($kn) . " هزار و";
        }
        if ($Hn) {
            $res .= (empty($res) ? "" : " ") . $tows[$Hn] . " و ";
        }
        if ($Dn || $n) {
            if (!empty($res)) {
                $res .= "";
            }
            if ($Dn < 2) {
                $res .= $ones[$Dn * 10 + $n];
            } else {
                $res .= $tens[$Dn];
                if ($n) {
                    $res .= " و " . $ones[$n];
                }
            }
        }
        if (empty($res)) {
            $res = "صفر";
        }
        $res = rtrim($res, " و");
        return $res;
    }

}
