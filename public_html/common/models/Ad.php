<?php

namespace common\models;

use yii\data\ActiveDataProvider;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "ad".
 *
 * @property integer $id
 * @property string $user_id
 * @property string $customer_id
 * @property string $resseler_id 
 * @property string $box_id
 * @property string $box_price
 * @property string $total_price
 * @property string $in_amount
 * @property string $title
 * @property string $image
 * @property string $date
 * @property string $date_publish
 * @property integer $box_qty
 * @property integer $pub_qty
 * @property string $date_old_ad
 * @property string $number_page_oldad
 * @property string $status
 * @property string $discount_rate
 * @property string $inc_rate
 * @property string $discount_price
 * @property string $prev_credit
 * @property string $price_credit
 * @property string $price_after_discount
 * @property string $avl_credit
 * @property string $benefit_rate
 * @property string $benefit_price
 * @property string $total_price_after_discount
 * @property string $info
 */
class Ad extends \yii\db\ActiveRecord {

    public $disc___;
    public $ad_in_page;
    public $num_full_page;
    public $file;
    public $attach_malii;
    public $filedoc;
    public $date1;
    public $date2;
    public $sum_gr;
    public $sum_be;
    public $sum_di;
    public $sum_in_amount;
    public $sum_benefit_price, $sum_remaind_1, $sum_remaind_2, $sum_remaind_3, $sum_remaind_4;
    public $takhfif_avalin_h_adi, $takhfif_tarhim_tasliyat, $d1, $d2, $d3, $d4, $b1, $b2, $b3, $b4;

// public $must_less;
    const ad_type = [
        10 => 'کارگزاران',
        11 => 'کارگزارن شهرستان',
        1 => 'دولتی تهران',
        11 => 'دولتی شهرستان',
        2 => 'نفتی تهران',
        13 => 'نفتی شهرستان',
        7 => 'شهرداری',
        5 => 'مستقیم',
        17 => 'پیام همشهری',
        // 6 => 'رایگان',
        18 => 'پیام همشهری- مترو',
        19 => 'مستقیم مترو',
        20 => 'کارگزار تلوزیون شهری',
        21 => 'کاگزار ویژه نامه',
        22 => 'همشهری آنلاین',
        //3 => ' ثبتی ',
        12 => 'ثبتی شهرستان',
            //4 => 'تهاتر',
// 8 => 'سازمانی',
//9 => 'خارجی',
// 15 => 'روزنامه رسمی',
// 16 => 'جهش تولید',
//  -1 => 'نامشخص'
    ];
    const action = [
        1 => 'view',
        2 => 'view',
        3 => 'document',
        4 => 'canceltarahi',
        4 => 'cancel_paziresh',
    ];
    const pay_type = [
        1 => 'نقدی',
        2 => 'اعتباری',
        3 => 'تهاتر',
        4 => 'رایگان',
    ];
    const action_text = [
        1 => 'تایید',
        2 => 'رد این مرحله',
        3 => 'درخواست ',
        4 => 'رد این مرحله',
        5 => 'درخواست ',
        6 => 'رد این مرحله برای',
    ];
    const status_tasks = [
        -1 => [//supervisor
            'acc_status' => [11],
            'action_acc' => [1],
        //'next_user' => [2],
        ],
        1 => [//supervisor
            'acc_status' => [5],
            'action_acc' => [1],
            'next_user' => [5],
            'rej_status' => [2],
            'prev_user' => [2],
            'action_rej' => [2],
        //'next_user' => [2],
        ],
        22 => [//rezvan
            'acc_status' => [2],
            'action_acc' => [1],
            'next_user' => [2],
        //'next_user' => [2],
        ],
        2 => [//paziresh
            'acc_status' => [1],
            'action_acc' => [1],
            'next_user' => [1],
            'rej_status' => [2],
            'prev_user' => [8],
            'action_rej' => [8],
        ],
        3 => [//sarparaste dabiri
            'acc_status' => [4],
            'next_user' => [4],
            'action_acc' => [1],
            'rej_status' => [2, 6],
            'prev_user' => [2, 6],
            'action_rej' => [2, 6],
//            'doc_status' => [2],
//            'doc_user' => [2],
        ],
        4 => [//maket
            'acc_status' => [5],
            'next_user' => [5],
            'action_acc' => [1],
            'action_rej' => [2],
            'prev_user' => [2],
            'rej_status' => [2],
        ],
        5 => [//tarahi
            'acc_status' => [6],
            'next_user' => [6],
            'action_acc' => [1],
            'action_rej' => [2],
            'prev_user' => [2],
            'rej_status' => [2],
        ],
        6 => [//dabiri
            'acc_status' => [3],
            'next_user' => [3],
            'action_rej' => [2, 5],
            'rej_status' => [2, 5],
            'prev_user' => [2, 5],
            'action_acc' => [1],
        // 'action_rej' => [2],
        ],
        7 => [//pazireshe aval
            'acc_status' => [8, 9],
            'next_user' => [8, 9],
            'action_acc' => [1, 1],
        ],
        8 => [//moshtari
            'acc_status' => [9],
            'next_user' => [9],
            'action_acc' => [1],
        ],
        9 => [//mali
//'acc_status' => [10],
// 'next_user' => [1],
            'action_acc' => [1],
        ],
    ];
    const status_tasks_mojoodi = [
        -1 => [//supervisor
            'acc_status' => [11],
            'action_acc' => [1],
        //'next_user' => [2],
        ],
        1 => [//supervisor
            'acc_status' => [4],
            'action_acc' => [1],
            'next_user' => [4],
            'rej_status' => [2],
            'prev_user' => [2],
            'action_rej' => [2],
        //'next_user' => [2],
        ],
        22 => [//rezvan
            'acc_status' => [2],
            'action_acc' => [1],
            'next_user' => [2],
        //'next_user' => [2],
        ],
        2 => [//paziresh
            'acc_status' => [3],
            'action_acc' => [1],
            'next_user' => [3],
            'rej_status' => [2],
            'prev_user' => [8],
            'action_rej' => [8],
        ],
        3 => [//sarparaste dabiri
            'acc_status' => [1],
            'next_user' => [1],
            'action_acc' => [1],
            'rej_status' => [2, 6],
            'prev_user' => [2, 6],
            'action_rej' => [2, 6],
//            'doc_status' => [2],
//            'doc_user' => [2],
        ],
        4 => [//maket
            'acc_status' => [5],
            'next_user' => [5],
            'action_acc' => [1],
            'action_rej' => [2],
            'prev_user' => [2],
            'rej_status' => [2],
        ],
        5 => [//tarahi
            'acc_status' => [6],
            'next_user' => [6],
            'action_acc' => [1],
            'action_rej' => [2],
            'prev_user' => [2],
            'rej_status' => [2],
        ],
        6 => [//dabiri
            'acc_status' => [3],
            'next_user' => [3],
            'action_rej' => [2, 5],
            'rej_status' => [2, 5],
            'prev_user' => [2, 5],
            'action_acc' => [1],
        // 'action_rej' => [2],
        ],
        7 => [//pazireshe aval
            'acc_status' => [8, 9],
            'next_user' => [8, 9],
            'action_acc' => [1, 1],
        ],
        8 => [//moshtari
            'acc_status' => [9],
            'next_user' => [9],
            'action_acc' => [1],
        ],
        9 => [//mali
//'acc_status' => [10],
// 'next_user' => [1],
            'action_acc' => [1],
        ],
    ];
    const page_type = array(
        1 => 'صفحه اول',
        2 => 'صفحه دوم',
        3 => 'صفحه سوم',
        4 => 'صفحه چهارم',
        5 => 'صفحه پنجم (بورس)',
        6 => 'صفحه ششم',
        7 => 'صفحه هفتم',
        8 => 'صفحه ویژه',
        9 => 'صفحه نهم',
        10 => 'صفحه داخلی',
        11 => 'صفحه جدول',
        12 => 'صفحه حوادث',
        13 => 'اول ورزشی',
        14 => 'آخر ورزشی',
        15 => 'دو صفحه ما قبل آخر',
        16 => ' صفحه ما قبل آخر',
        17 => 'صفحه آخر',
        18 => 'ترحیم وتسلیت',
    );
    const page_type_2 = array(
        1 => 'صفحه اول',
        2 => 'صفحه دوم',
        3 => 'صفحه سوم',
        4 => 'صفحه چهارم',
        5 => 'صفحه پنجم(بورس)',
        6 => 'صفحه ششم و صفحه هفتم',
        7 => 'صفحه ویژه',
        8 => 'صفحه نهم',
        28 => 'صفحه ویژه دوم',
        29 => 'صفحه ویژه سوم',
        30 => 'صفحه ویژه چهارم',
        9 => 'صفحه داخلی',
        18 => 'صفحه داخلی دوم',
        19 => 'صفحه داخلی سوم',
        20 => 'صفحه داخلی چهارم',
        21 => 'صفحه داخلی پنجم',
        22 => 'صفحه داخلی ششم',
        23 => 'صفحه داخلی هفتم',
        24 => 'صفحه داخلی هشتم',
        25 => 'صفحه داخلی نهم',
        26 => 'صفحه داخلی دهم',
        27 => 'صفحه داخلی یازدهم',
        10 => 'صفحه جدول',
        11 => 'صفحه حوادث',
        12 => 'اول ورزشی',
        13 => 'آخر ورزشی',
        14 => 'دو صفحه ما قبل آخر',
        15 => ' صفحه ما قبل آخر',
        16 => 'صفحه آخر',
        17 => 'ترحیم وتسلیت',
    );
    const data_ad_in_page = array(
        48 => 'تمام صفحه',
        24 => 'نیم صفحه',
        12 => 'یک چهارم صفحه'
    );
    const ad_order = array(
        1 => 'supervisor_id',
        2 => 'paziresh_id',
        3 => 'sarparast_dabiri_id',
        4 => 'maket_id',
        5 => 'tarahi_id',
        6 => 'dabiri_id',
        7 => 'paziresh_id',
        8 => 'resseler_id',
        9 => 'mali_id',
        22 => 'rezvan_id',
    );
    const view_level = array(
        1 => 'سوپروایزر',
        2 => 'پذیرش',
        3 => 'سرپرست دبیری',
        4 => 'ماکت',
        5 => 'طراحی',
        6 => 'دبیری',
        8 => 'کارگذار',
        9 => 'مالی',
    );
    const status_text = array(
        -10 => 'باطله',
        11 => 'چاپ شده',
    );
    const status_present = array(
        0 => 'غایب',
        1 => 'حاضر',
    );
    const status_request = array(
        0 => 'پرداخت نشده',
        1 => 'پرداخت شده',
            //2 => 'کارمزد اعتباری پرداخت نشده',
            //3 => 'کارمزد اعتباری پرداخت شده',
    );
    const status_next_user = array(
        2 => ' و ارسال برای پذیرش ',
        3 => ' و ارسال برای سرپرست دبیری',
        4 => '  و ارسال برای ماکت',
        5 => ' و ارسال برای طراحی',
        6 => ' و ارسال برای دبیری ',
        7 => ' و ارسال برای پذیرش اول',
        8 => 'و ارسال برای مشتری',
        9 => 'و ارسال برای مالی',
        1 => 'و ارسال برای سوپروایزر',
    );
    const status_cancel_text = array(
        2 => ' برای پذیرش',
        5 => ' برای طراحی',
        6 => 'برای دبیری',
        8 => 'رد این مرحله برای کارگذار'
    );
    const status_color = array(
        -10 => '#ff000096',
        1 => '#7b797996',
        2 => '#0000ffa1',
        3 => '#0fffffa1',
        4 => '#f1a10996',
        5 => '#ffbbff7d',
        6 => '#ff00ff8c',
        7 => '#0080808a',
        8 => '#a52a2ab0',
        9 => '#80008085',
        10 => '#0ccccc96',
        11 => '#0080008c',
        22 => '#88884477',
    );
    const status_task = array(
        0 => 'تمام شده',
        1 => 'نا تمام',
    );

    /**
     * @inheritdoc
     */
    public $gallery;
    public $table;
    public $persian;
    public $name;
    public $status_text;
    public $discount_1, $discount_2, $discount_3, $discount_4, $discount_5;
    public $status_task;
    public $task_list = array();

    public function rules() {
        return [
            [['date_publish', 'box_qty', 'pub_qty',], 'required', 'on' => 'create_final'],
            [['document', 'attach_malii', 'attachh', 'mim', 'doc', 'gallery', 'file', 'paziresh_id', 'active_user_id', 'serial', 'customer_id', 'info', 'filedoc', 'title', 'resseler_id', 'box_id', 'customer_confirmation', 'box_price', 'total_price', 'in_amount', 'image', 'date', 'date_publish', 'box_qty', 'all_qty', 'pub_qty', 'frame', 'status', 'discount_rate', 'inc_rate', 'discount_price', 'prev_credit', 'price_credit', 'price_after_discount', 'avl_credit', 'benefit_rate', 'benefit_price', 'total_price_after_discount', 'copy_ad_id', 'tejari', 'if_changed', 'mali_attach', 'benefit', 'date1', 'date2', 'ad_type', 'cer_no', 'id_ad', 'naghdi_etebari', 'benefit_status', 'data_pic', 'ad_in_page', 'discount_p', 'if_rejected', 'fani', 'agahi_in_page', 'logo', 'first_page', 'rezvan_id', 'sarparast_first', 'constt', 'title', 'inner_page_info', 'custom_id', 'pelekani', 'cash','fix_discount','code_kargah','date_publish2'], 'safe'],
            [['date_publish', 'customer_id'], 'required', 'on' => 'create'],
            [['total_price',], 'required', 'on' => 'save_discount'],
            [['box_qty', 'pub_qty'], 'integer'],
            //[['box_qty'], 'must_less', 'on' => 'less'],
            //  [['box_id'], 'change_box_id', 'on' => 'change_box_id'],
//   ['customer_id', 'etd_eta', 'on' => 'create_final'],
            ['customer_id', 'etd_eta', 'on' => 'create'],
            //   ['serial', 'serial_check'],
            ['custom_id', 'unique']
        ];
    }

// public function change_box_id($attribute, $params) {
//        $ad_table = Ad::find()->where(['id' => $this->id])->one();
//        $ad_box_id = $ad_table->box_qty;
//        $box_id = $this->box_qty;
//
////        if ($ad_box_id == $box_id) {
//          
//           // $this->addError($attribute, 'تعداد کادر باید کمتر باشد');
//            return false;
////        
//        if($ad_box_id != $box_id) {
//
//                $ad_table->if_changed=1;
//                $ad_table->box_id=$box_id;
//            $ad_table->save(false);
//            return true;
//            
//        }
//    }


    public function etd_eta($attribute, $params) {

//$this->addError('customer_id',$this->date_publish);

        if ($this->date_publish)
            $date_add_exists = Ad::find()->where(['date_publish' => ($this->date_publish), 'customer_id' => $this->customer_id])->exists();

        if ($date_add_exists) {
            $this->addError('customer_id', 'برای این مشتری و این تاریخ قبلا یک آگهی ثبت شده است');
        }
    }

//const 
    public static function arabic_w2e($str) {
        $arabic_eastern = array('٠', '١', '٢', '٣', '٤', '٥', '٦', '٧', '٨', '٩');
        $arabic_western = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
        return str_replace($arabic_western, $arabic_eastern, $str);
    }

    public static function tableName() {
        return 'ad';
    }

    const type = array(1 => 'تجاری', 2 => 'غیر تجاری');

// public static function finish(){
//     
// }
    public static function sumtype($date, $res_id = null) {
        $sum = 0;
        return $date;
        if ($res_id) {
//            echo "no";
            $ad = Ad::find()->where(['resseler_id' => $res_id])->andWhere(['date_publish' => $date])->all();
        } else {
//            echo 'in';
            $ad = Ad::find()->where(['date_publish' => $date])->all();
        }
        foreach ($ad as $a) {
            if ($a->ad_type == 7 or $a->ad_type == 1 or $a->ad_type == 11 or $a->ad_type == 2 or $a->ad_type == 13 or $a->resseler_id == 480) {
                $sum += ($a->in_amount) - ($a->benefit_price);
            }
        }
        return $sum;
    }

    public static function adtype($date, $res_id = null, $type = null) {
        $sum = 0;

        if ($res_id) {
            $ad = Ad::find()->where(['resseler_id' => $res_id])->andWhere(['date_publish' => $date])->all();
        } else {
            $ad = Ad::find()->where(['date_publish' => $date])->all();
        }
        foreach ($ad as $a) {
            if ($a->ad_type == 7 and $type == 7) {
                $sum += ($a->in_amount) - ($a->benefit_price);
            } elseif ($a->ad_type == 1 or $a->ad_type == 11 and $type == 1 or $type == 11) {
                $sum += ($a->in_amount) - ($a->benefit_price);
            } elseif ($a->ad_type == 2 or $a->ad_type == 13 and $type == 2 or $type == 13) {
                $sum += ($a->in_amount) - ($a->benefit_price);
            } elseif ($a->resseler_id == 480) {
                $sum += ($a->in_amount) - ($a->benefit_price);
            } elseif ($a->ad_type == 10 and $type == 10) {
                $sum += ($a->in_amount) - ($a->benefit_price);
            }
        }
        return $sum;
    }

    public static function division($month1, $month2, $res_id) {

        $date1 = Persian::get_current_month_report($month1);
        $date1 = (explode(" ", $date1));
        $date2 = Persian::get_current_month_report($month2);
        $date2 = (explode(" ", $date2));

        $ad_month1 = Ad::find()->where(['resseler_id' => $res_id])->andWhere(['between', 'date_publish', $date1[1], $date1[0]])->all();
        $sum_month1 = 0;
        foreach ($ad_month1 as $ad1) {
            $sum_month1 += $ad1->in_amount;
        }


        $ad_month2 = Ad::find()->where(['resseler_id' => $res_id])->andWhere(['between', 'date_publish', $date2[1], $date2[0]])->all();
        $sum_month2 = 0;
        foreach ($ad_month2 as $ad2) {
            $sum_month2 += $ad2->in_amount;
        }
//       return $sum_month2."-". $sum_month1;
        if ($sum_month1 > 0)
            return (($sum_month2 / $sum_month1) - 1);
        else {
            return (00.0);
        }
    }

    public static function report($month, $res_id = null, $dataProvider = null) {


        if (is_array($res_id)) {
            $res_id = $res_id['resseler_id'];
        }

        $date = Persian::get_current_month_report($month);

        $ad_month = Ad::find();
        if ($res_id) {
            $ad_month = $ad_month->where(['resseler_id' => $res_id]);
        }
        $ad_month = $ad_month->andWhere(['between', 'date_publish', $date[0], $date[1]])->all();

        $sum_month = 0;
        foreach ($ad_month as $ad) {
            $sum_month += ($ad->in_amount);
        }
        return number_format($sum_month);
    }

    public static function sahm($type1 = null, $type2 = null, $res_id = null) {
        $date = Persian::get_from_beggining_year(1);
        $now_date = date('Y-m-d');
        if ($type1 and $type1 != 20) {
            $ad_type1 = Ad::find()->where(['ad_type' => $type1])->andWhere(['between', 'date_publish', $date, $now_date])->all();
            $sum_type1 = 0;
            foreach ($ad_type1 as $ad) {
                $sum_type1 += $ad->cash;
            }
            $sum = $sum_type1;
        } elseif ($type1 and $type1 == 20) {
            $ad_all = Ad::find()->where(['is not', 'ad_type', null])->andWhere(['between', 'date_publish', $date, $now_date])->all();
            $sum_all = 0;
            foreach ($ad_all as $ad) {
                $sum_all += $ad->cash;
            }
            $sum = $sum_all;
        } elseif ($res_id) {
//            echo $res_id;

            $ad_res = Ad::find()->where(['resseler_id' => $res_id])->andWhere(['between', 'date_publish', $date, $now_date])->all();
            $sum_res = 0;
            foreach ($ad_res as $ad) {
                $sum_res += $ad->cash;
            }
//            echo $sum_res;  
            $sum = $sum_res;
        }
        if ($type2) {
            $ad_type2 = Ad::find()->where(['ad_type' => $type2])->andWhere(['between', 'date_publish', $date, $now_date])->all();
            $sum_type2 = 0;
            foreach ($ad_type2 as $ad) {
                $sum_type2 += $ad->cash;
            }
            $sum = $sum_type2 + $sum_type1;
        }


        return number_format($sum);
    }

    public static function sum($month, $res_id) {

        $date = Persian::get_from_beggining_year($month);
//      
        $now_date = date('Y-m-d');
//        
        $ad_month = Ad::find()->where(['resseler_id' => $res_id])->andWhere(['between', 'date_publish', $date, $now_date])->all();
//        print_r($ad_month);
        $sum_month = 0;
        foreach ($ad_month as $ad) {
            $sum_month += $ad->cash;

//            echo $ad->in_amount;
        }
//        echo $sum_month;
        return number_format($sum_month);
    }

    public static function cal_price__($in_amount, $price, $discount_arr, $one_pub, $all_pub, $num_pub_qty, $benefitt, $edit_id,
            $custid, $arr, $resid = null, $confirm = null, $free = null, $cer = null, $iddd_ad = null, $mim = null, $contract = null,
            $contractprice = null, $titlee = null, $pub_date = null, $tej = null, $pay, $box_id_ad = null, $ad_in_page = null,
            $naghdi_etebari = null, $ad_typee = null, $agahi = null, $inc_kh = null, $date = null, $steps_discount = null, $vat = null,$fix_discount=null,$code_kargah=null,$pub_date2=null) {


        //echo "x".$vat."2*";
        //echo $price."*";
        //exit();
//echo "*".$edit_id."*";
        if ($edit_id != null) {


//echo $edit_id."*";

            $ad = Ad::findOne(['id' => $edit_id]);
        } else {

            $ad = Ad::check_new_order(null, $resid);
        }




        if (2 > 1) {
            $changed = 2;
            if ($changed == 1) {
                $ad->status_change = 1;
            } else {
                $ad->status_change = 2;
            }

            $ad->customer_confirmation = $confirm;
            $ad->vat = $vat;

            $ad->code_kargah = $code_kargah;

            $ad_id = $ad->id;
            AdHasDiscount::deleteAll(['ad_id' => $ad_id]);

            $total_inc = 0;
            $discount_arr_disc = [];
            $discount_arr_inc_price = [];

            $ret = array();
            $ret['discount'] = array();

            $in_amount = $price;

            $ret['sum_discount'] = 0;

            if ($ad_typee == 6) {

                $discount_arr[25] = [100, 2];
            }
//echo $benefitt;
            //if ($naghdi_etebari == 1) {
// if (Yii::$app->user->identity->credit_naghdi >= $in_amount) {


            if ($_GET['cash_discount'] == 1) {

                $discount_arr[125] = [5, 2];
            } elseif ($_GET['cash_discount'] == 2) {
                $discount_arr[126] = [5, 3];
            }


// }
            //}
// print_r($discount_arr);

            if (!empty($discount_arr)) {


//                echo "Hi<br>";
//                print_r($discount_arr);
//                echo "<hr>";

                foreach ($discount_arr as $disc__) {

                    if ($disc__[1] == 1 and $disc__[2] != 1) { // فقط افزایش اعتبار
                        $sum_d1 += $disc__[0];
                        // echo "dd1<br>";
                    }

                    if ($disc__[1] == 2)
                        $sum_d2 += $disc__[0];

                    if ($disc__[1] == 1 and $disc__[2] == 1) { // فقط تخفیف مرحله اولی
                        $sum_d3 += $disc__[0];
                        // echo "dd3<br>";
                    }
                }


                //echo $sum_d1."<hr>";
//echo $sum_d1."<hr>".$sum_d2;
//print_r($discount_arr);
//echo $price;
//exit();





                $sum_disc_1 = 0;
                $temp_discount_2_sum = 0;
                $temp_discount_2_rate = 0;

                foreach ($discount_arr as $key => $disc__) {



                    //exit();

                    $find_name = \common\models\DiscountItem::find()->select('name')->where(['id' => $key])->one();

                    $model_ad_has = new AdHasDiscount;
                    $model_ad_has->ad_id = $ad_id;
                    $model_ad_has->discount_id = $key;
                    if ($disc__[1] == 1 and $disc__[2] == 1) {


                        // echo "d3::" . $key . "<br>";

                        $model_ad_has->discount_rate = $disc__[0];
                        if ($num_pub_qty > 1) {
                            $model_ad_has->discount_price = ($in_amount * ($disc__[0] / 100)) / $num_pub_qty;
                        } else {
                            $model_ad_has->discount_price = ($in_amount * ($disc__[0] / 100));
                        }

                        //   echo $model_ad_has->discount_price."<br>";

                        $model_ad_has->discount_level = 1;

                        $model_ad_has->custom_name = $disc__[2];
                        $model_ad_has->inc_rate = $disc__[0];
                        $model_ad_has->save();
                        //echo $model_ad_has->discount_id;

                        $temp_discount = array();
                        $temp_discount['type'] = 2;
                        $temp_discount['discount_id'] = $model_ad_has->discount_id;
                        $temp_discount['discount_inc'] = $model_ad_has->inc_rate;
                        $temp_discount['discount_name'] = $find_name->name . ":" . $disc__[2];
                        $temp_discount['discount_rate'] = number_format($model_ad_has->discount_rate, 4);

//$ret['sum_discount'] += ($temp_discount['discount_rate'] );
                        $temp_discount['discount_price'] = number_format($model_ad_has->discount_price);
                        $temp_discount_3_rate += $model_ad_has->inc_rate;
                        $temp_discount_3_sum += $model_ad_has->discount_price;
                        array_push($ret['discount'], $temp_discount);
                    }
                }

                $in_amount -= $temp_discount_3_sum;

                //echo "in after 3:".$in_amount."<br>";
                //$in_amount = $in_amount / (1 + ($sum_d1 / 100));
                //echo $in_amount."<br>";

                foreach ($discount_arr as $key => $disc__) {


                    if (!$key)
                        continue;

                    // echo $key."key<br>";

                    $find_name = \common\models\DiscountItem::find()->select('name')->where(['id' => $key])->one();

                    $model_ad_has = new AdHasDiscount;
                    $model_ad_has->ad_id = $ad_id;
                    $model_ad_has->discount_id = $key;
                    if ($disc__[1] == 1 and $disc__[2] != 1) {

                        //echo  "d1::".$key."<br>";


                        $model_ad_has->discount_rate = ((($disc__[0]) / 100) / (1 + ($sum_d1 / 100))) * 100;
                        if ($num_pub_qty > 1) {
                            $model_ad_has->discount_price = ($in_amount * ($model_ad_has->discount_rate / 100)) / $num_pub_qty;
                        } else {
                            $model_ad_has->discount_price = ($in_amount * ($model_ad_has->discount_rate / 100));
                        }
//echo  $model_ad_has->discount_price; 





                        $model_ad_has->discount_level = 1;

                        $model_ad_has->inc_rate = $disc__[0];
                        $model_ad_has->save();

                        $temp_discount = array();
                        $temp_discount['type'] = 1;
                        $temp_discount['discount_id'] = $model_ad_has->discount_id;
                        $temp_discount['discount_inc'] = $model_ad_has->inc_rate;
                        $temp_discount['discount_name'] = $find_name->name;
                        $temp_discount['discount_rate'] = number_format($model_ad_has->discount_rate, 4);

                        $ret['sum_discount'] += ($temp_discount['discount_rate'] );
                        $temp_discount['discount_price'] = number_format($model_ad_has->discount_price);

                        $sum_disc_1 += $model_ad_has->discount_price;
                        array_push($ret['discount'], $temp_discount);
                    }
                }


                $ret['sum_discount_1_rate'] = $ret['sum_discount'];
                $ret['sum_discount_1_price'] = number_format($sum_disc_1);

                $in_amount -= $sum_disc_1;

                $customer_tab = Customer::find()->where(['id' => $custid])->one();

                foreach ($discount_arr as $key => $disc__) {






                    if ($disc__[1] == 3) {
                        // echo  "bnef<br>";

                        $find_name = \common\models\DiscountItem::find()->select('name')->where(['id' => $key])->one();

                        $model_ad_has = new AdHasDiscount;
                        $model_ad_has->ad_id = $ad_id;
                        $model_ad_has->discount_id = $key;
                        $model_ad_has->discount_rate = $disc__[0];
                        $model_ad_has->discount_price = 0;
                        $model_ad_has->is_benefit = 1;
                        $model_ad_has->save();
                        // echo $disc__[0]."/";
                        $benefitt += $disc__[0];

                        //print_r($model_ad_has->getErrors());
                    }
                }

                //echo $benefitt."*";
                //$in_amount = $price - $sum_disc_1;
                //echo "in:".$in_amount."<br>";

                $temp_price_in_amount = $in_amount ;
                foreach ($discount_arr as $key => $disc__) {


                    //echo $key."*";
                    //exit();



                    $find_name = \common\models\DiscountItem::find()->select('name')->where(['id' => $key])->one();

                    $model_ad_has = new AdHasDiscount;
                    $model_ad_has->ad_id = $ad_id;
                    $model_ad_has->discount_id = $key;
                    if ($disc__[1] == 2) {


                        //  echo "in:".$in_amount."<br>";
                        //echo  "d2:".$key."<br>";

                        $model_ad_has->discount_rate = $disc__[0];



                        if($steps_discount){

                            if ($num_pub_qty > 1) {

                                $model_ad_has->discount_price = ($temp_price_in_amount * ($disc__[0] / 100))/ $num_pub_qty;
                            
                                $total_discount += $model_ad_has->discount_price;
                                $temp_price_in_amount -= $model_ad_has->discount_price;

                            }else{
                                $model_ad_has->discount_price = $temp_price_in_amount * ($disc__[0] / 100);
                                
                                $total_discount += $model_ad_has->discount_price;
                                $temp_price_in_amount -= $model_ad_has->discount_price;

                            }
                           

                        }else{

                            if ($num_pub_qty > 1) {
                                $model_ad_has->discount_price = ($in_amount * ($disc__[0] / 100)) / $num_pub_qty;
                            } else {
                                $model_ad_has->discount_price = ($in_amount * ($disc__[0] / 100));
                            }

                        }
                        


                        


                        

                        //echo $model_ad_has->discount_price."<br>";

                        $model_ad_has->discount_level = 2;

                        $model_ad_has->custom_name = $disc__[2];
                        $model_ad_has->inc_rate = $disc__[0];
                        $model_ad_has->save();
                        //echo $model_ad_has->discount_id;

                        $temp_discount = array();
                        $temp_discount['type'] = 2;
                        $temp_discount['discount_id'] = $model_ad_has->discount_id;
                        $temp_discount['discount_inc'] = $model_ad_has->inc_rate;
                        $temp_discount['discount_name'] = $find_name->name . ":" . $disc__[2];
                        $temp_discount['discount_rate'] = number_format($model_ad_has->discount_rate, 4);


                        

//$ret['sum_discount'] += ($temp_discount['discount_rate'] );
                        $temp_discount['discount_price'] = number_format($model_ad_has->discount_price);
                        $temp_discount_2_rate += $model_ad_has->inc_rate;
                        $temp_discount_2_sum += $model_ad_has->discount_price;
                        array_push($ret['discount'], $temp_discount);
                    }
                }

                $ret['sum_discount_2_rate'] = $temp_discount_2_rate;
                $ret['sum_discount_2_price'] = number_format($temp_discount_2_sum);
                $ret['sum_discount'] += ($temp_discount_2_sum * 100 ) / max($price, 1);
            } else {

                $in_amount = $price;
                $ret['discount'] = 0;
                $ret['sum_discount'] = 0;
                $discount_arr = [];
            }

            if (Yii::$app->user->identity->code_kargozar == 500)
                $benefitt = 0;



//echo $ad_typee."*";
//echo $ad->id;

            $in_amount -= $temp_discount_2_sum;
            //echo $in_amount."<br>";
            //echo number_format($temp_discount_2_sum+$sum_disc_1);

            if ($arr) {
                $customer_tab->takhfifat = json_encode($arr);
                $customer_tab->save(false);
            }



            $user_p = User::find()->where(['lvl' => 2, 'status_p' => 1])->all();
            $array_list = array();
            foreach ($user_p as $a) {
                $c = 0;
                $c = Task::find()->where(['user_id' => $a->id])->count();
                array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
            }
            $keys = array_column($array_list, 'count');
            array_multisort($keys, SORT_ASC, $array_list);
            $next_user_id = $array_list[0]['user_id'];

            if ($resid and $changed != 1 and Yii::$app->user->identity->lvl == 2) {

                $next_user_id = Yii::$app->user->id;
                $ad->resseler_id = $resid;
                $ad->paziresh_id = $next_user_id;
                $ad->active_user_id = $next_user_id;
            } elseif ($resid and $changed != 1 and Yii::$app->user->identity->lvl != 2) {


                $ad->resseler_id = $resid;
                $ad->paziresh_id = $next_user_id;
                $ad->active_user_id = $next_user_id;
            } elseif ($resid and $changed == 1) {

                $ad->resseler_id = $resid;
            } elseif (!$resid and $changed == 1) {

                $ad->resseler_id = Yii::$app->user->id;
            } elseif (!$resid and $changed != 1) {

                $ad->paziresh_id = $next_user_id;
                $ad->active_user_id = $next_user_id;
            }


            if ($free == 1) {
                $in_amount = 0;
            }
            $ad->pub_qty = $num_pub_qty;

//echo $in_amount;




            if ($num_pub_qty > 1) {
                $ad->in_amount = $in_amount / $num_pub_qty;
                $ad->benefit_price = (($in_amount * ($benefitt / 100)) / $num_pub_qty);
                $ad->total_price = $price / $num_pub_qty;
                $ad->total_price_after_discount = (($price - $ret['sum_discount']) / $num_pub_qty);
                $ad->price_after_discount = ($in_amount - $ret['sum_discount']) / $num_pub_qty;
                $ad->discount_price = (($in_amount * ($val / 100)) / $num_pub_qty);
                $ad->discount_p = $ret['sum_discount'];
            } else {
                $ad->in_amount = $in_amount;
                $ad->benefit_price = ($in_amount * ($benefitt / 100));
                $ad->total_price = $price;
                $ad->total_price_after_discount = $price - $ret['sum_discount'];
                $ad->price_after_discount = $in_amount - $ret['sum_discount'];
                $ad->discount_price = round($temp_discount_2_sum + $sum_disc_1); //($price * ($ret['sum_discount'] / 100));
                $ad->discount_p = $ret['sum_discount'];
            }

            

            

            ///echo $ad->discount_price;

            $ad->benefit_price = round($ad->benefit_price);
            $ad->in_amount = round($ad->in_amount);
            $ad->total_price_after_discount = round($ad->total_price_after_discount);

//echo $benefitt;
//echo "*".$ad->ad_type;


            $ret['sum_discount'] += $temp_discount_3_rate;




            if($fix_discount){

                //echo "fixed..";
                $ad->discount_price = $fix_discount;
                $ad->fix_discount = $fix_discount;
                $ret['sum_discount'] = 'fix';
                $ad->in_amount = $in_amount -= $fix_discount;

                // $ret['sum_discount'] = 
                //$ad->discount_price =  $fix_discount;;
                //echo $ad->discount_price;//$ret['sum_discount'];
                //exit();
                //echo $ad->total_price_after_discount."<br>";
                //echo  $ad->price_after_discount;
             
             }


            $ad->discount_p = $ret['sum_discount'];

            if ($ad->discount_p > 55) {

                //$ret['sum_discount'] = 55;
                $ad->discount_price = ($price * ($ret['sum_discount'] / 100));
                $ad->discount_p = $ret['sum_discount'];
            }

//echo $in_amount."<br>";
            if ($customer_tab->takhfif) {

                $sec_takhf = ($in_amount * ($customer_tab->takhfif / 100));
//echo $sec_takhf;
//echo $ad->discount_price;
                $ad->discount_price += $sec_takhf;

                $ad->discount_p = $ad->discount_price / $price;

                $in_amount -= ($in_amount * ($customer_tab->takhfif / 100));
            }
// echo $in_amount."<br>";
//echo  $in_amount; //$ad->discount_price;
// echo $customer_tab->takhfif;
            //echo number_format($ad->discount_price)."<hr>";
            //echo  number_format($in_amount)."<hr>";
            //echo  number_format($price)."<hr>";
            //echo "hi<br>";

            $ad->pelekani = $steps_discount;

            //echo number_format($price) . "[]<hr>";
            if ($steps_discount) {




                $temp_price = $price;

                $in_amount = $price;
                $total_discount = 0;
                foreach (AdHasDiscount::find()->where(['ad_id' => $ad_id, 'is_benefit' => null])->all() as $d) {


                    //echo $d->discount_rate . "<br>";
                    $dec_temp = $temp_price * ($d->discount_rate / 100);
                    //echo number_format($dec_temp) . "<br>";
                    $total_discount += $dec_temp;
                    $temp_price -= $dec_temp;

                    //echo $temp_price."<br><hr>";
                }


                //echo number_format($total_discount) . "[]<hr>";
                //echo number_format($temp_price) . "[]<hr>";
                $ad->discount_price = $total_discount;
                $in_amount -= $ad->discount_price;
                $ad->in_amount = $in_amount;
                //echo $total_discount;
            }


            //echo $ad->in_amount;



            //echo $ad->benefit_rate."*";
            $ad->benefit_price = (($in_amount * ($ad->benefit_rate / 100)));

            //echo $ad->benefit_price;
            // exit();

            $ad->discount_price = ($ad->discount_price);

            $ad->status = 11;
            $ad->pay_status = 0;
            $ad->naghdi_etebari = $pay;
            $ad->scenario = "save_discount";
            $ad->benefit_rate = $benefitt;
            $ad->agahi_in_page = $agahi;

            $ad->discount_rate = array_sum($discount_arr);
            $ad->inc_rate = array_sum($discount_arr);

            $ad->box_qty = $one_pub;
            $ad->fee_Increase = $inc_kh;
            $ad->all_qty = $all_pub;
            $ad->customer_id = $custid;
            $ad->ad_type = $ad_typee;

            // echo $ad->ad_type."*2<br>";

            $ad->title = $titlee;
            $ad->box_id = $box_id_ad;
            $ad->box_price = Ad::get_type_price($ad->ad_type, $ad->box_id, $pub_date, $inc_kh);
            $ad->ad_in_page = $ad_in_page;
            $ad->naghdi_etebari = $naghdi_etebari;

            //$pub_date = 
            $ad->date_publish = Persian::convert_date_to_en(Persian::persian_digit_replace($pub_date));
            if($pub_date2)
            $ad->date_publish2 = Persian::convert_date_to_en(Persian::persian_digit_replace($pub_date2));
            else
            $ad->date_publish2 = null;

            $ad->date = Persian::convert_date_to_en(Persian::persian_digit_replace($date));
            $ad->tejari = $tej;

            if ($naghdi_etebari == 4) {
                $ad->pay_status = 1;
            }


//echo $ad->benefit_rate;
            $ad->id_ad = $iddd_ad;
            $ad->mim = $mim;
            $ad->contract_id = $contract;
            $ad->cer_no = $cer;
            $ad->save(false);

            $send_amount = $ad->in_amount;
            if ($naghdi_etebari == 1)
                $send_amount -= $ad->benefit_price;

            Transition::update_first_transction($ad->id, $send_amount, $ad->resseler_id, $naghdi_etebari);

            //echo $in_amount."<br>";
            //echo $ad->benefit_price;
            //echo number_format(($in_amount) - $ad->benefit_price);


            $ret['sum_discount_rate'] = round($ad->discount_p);

            $ad->discount_price += $temp_discount_3_sum;
            $ret['sum_discount'] = (number_format($ad->discount_price)); // جمع کل تخفیف 

            $ret['sum_inc'] = number_format($ad->inc_rate);

            $safe_price = $price;

            if ($ad->naghdi_etebari == 4) {
                $ad->in_amount = 0;
                $in_amount = 0;
                $ad->discount_price = $safe_price;
                $ad->benefit_price = 0;
                $ad->benefit_rate = 0;

                $price = 0;
                $ret['khales'] = 0;
                $ret['sum_discount'] = 100;
            }

            $ad->save();

            $ret['price'] = number_format($safe_price);

// $customer_ta = Customer::find()->where(['id' => $custid])->one();
            $ret['takhfif'] = $customer_tab->takhfif;
            if ($inc_kh)
                $ret['temp_p_n'] = $inc_kh;
            $ret['sum_box_qty'] = $ad->all_qty;

            $ret['benefit_rate'] = $ad->benefit_rate;
            //echo $ad->benefit_rate;
            $ad->benefit_price = ($in_amount * ($ad->benefit_rate / 100));
            $ret['benefit_price'] = number_format($ad->benefit_price);
 
            if ($ad->vat) {

               
                $v = VatYear::vatfinder($ad);
                $ret['vat'] = number_format((int) $in_amount * $v);
                $ad->vat_price = $ret['vat'];
                $in_amount *= (1+$v);
            } else {
                $ret['vat'] = 0;
            }

            // echo $ad->benefit_price;

            $ret['needed'] = number_format($in_amount);
            $ret['khales'] = number_format(($in_amount) - $ad->benefit_price);

            //echo $ad->ad_type."***";

            $ad_type = \common\models\AdType::findOne($ad->ad_type);
            $ret['price_orginal'] = number_format(Ad::get_type_price($ad->ad_type, $ad->box_id, $pub_date));
            $ret['ad_id'] = $ad->id;
            $ret['discount_price'] = $ad->discount_price;
        }
        return json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public static function neworder() {

        $ad = Ad::check_new_order();

        $user_table = User::find()->where(['id' => $ad->resseler_id])->one();
        $sum = $user_table->credit + $user_table->saghf_etebar;
        $str_credit = (string) $user_table->credit;
        $str_credit = str_replace("-", "", $str_credit);

        $summ = $ad->in_amount + $str_credit;

        if ($user_table->etebar == 0 or $ad->in_amount > $user_table->saghf_etebar or $summ > $user_table->saghf_etebar)
            return json_encode(['flag' => -1, 'eer' => array(1 => 'اعتبار شما کافی نیست*')]);
        else {
            $user_table->credit -= $ad->in_amount;
            $user_table->save(false);
            $ad->credit -= $ad->in_amount;
            $ad->save(false);
        }
        $doc = new \common\models\Document();

// return json_encode(['data' => $_POST]);

        if ($_FILES["file"]["name"] != '') {
            $test = explode('.', $_FILES["file"]["name"]);
            $ext = end($test);
            $name = rand(100000, 99999999) . '.' . $ext;
            $location = 'uploaded_document/' . $name;
            move_uploaded_file($_FILES["file"]["tmp_name"], $location);
//$m =  '<img src="'.$location.'" height="150" width="225" class="img-thumbnail" />';
        }


        $date_pub = $_POST['date_publish'];
        if ($date_pub)
            $date_pub = Persian::convert_date_to_en(Persian::persian_digit_replace($date_pub));

        $ad_id = $ad->id;

        $model_ad = Ad::find()->where(['id' => $ad_id])->one();

//echo $model_ad->id;

        $model_ad->scenario = "create_final";
        $model_ad->info = $_POST['body'];
        $model_ad->date = date('Y-m-d H:i:s');

        $model_ad->date_publish = $date_pub;
        $model_ad->title = $_POST['title'];
        $model_ad->customer_id = $_POST['customer_id'];
        $model_ad->box_id = $_POST['box_id'];
        $model_ad->pub_qty = $_POST['pub_qty'];
        $model_ad->frame = $_POST['frame'];

        $model_ad->status = -1;

        $doc->file = $location;
        $doc->ad_id = $ad_id;
        $doc->customer_id = $model_ad->customer_id;
        $doc->save(false);
        $get = $_GET['id'];

// return json_encode(['flag' => -1, 'eer' => $model_ad->getErrors(),'customer'=>$_POST['customer_id']]);

        if ($model_ad->save()) {
            Yii::$app->session->setFlash('success', "آگهی ثبت شد منتظر تایید بمانید...");
            return json_encode(['flag' => 1]);
        } else {
            Yii::$app->session->setFlash('erroro', " خطایی پسش آمد در فرصتی دیگر  تلاش کنید");
            return json_encode(['flag' => -1, 'eer' => $model_ad->getErrors()]);
        }

        return json_encode($model_ad->id);

//        $all = $_POST;
//
//        return;








        return $this->render('site/new_order', [
                    '$model_ad' => $model_ad,
        ]);
    }

    public static function assign_task($ad_id, $acc_status, $next_user) {
        $ad = Ad::findOne($ad_id);
        $task = new Task;
        $user_online = Yii::$app->user->identity->id;

        $task = Task:: find()->where(['user_id' => $user_online])->andwhere(['model_id' => $ad_id])->one();
        if ($task->status == 0) {
            $task->status = 1;
            $task->end_time = date('Y-m-d H:i:s');
            $task->save(false);
        }
        $ad->status = $acc_status;
        $next_user_id = $ad->{Ad::ad_order[$ad->status]};
        if (!$next_user_id) {
            $user_p = User::find()->where(['lvl' => $next_user])->all();
            $array_list = array();
            foreach ($user_p as $a) {
                $c = 0;
                $c = Ad::find()->where(['active_user_id' => $a->id])->count();
                array_push($array_list, ['user_id' => $a->id, 'count' => $c]);
            }
            $keys = array_column($array_list, 'count');
            array_multisort($keys, SORT_ASC, $array_list);
            $next_user_id = $array_list[0]['user_id'];
        }
        $ad->active_user_id = $next_user_id;
        $task->model_id = $ad_id;
        $task->user_id = $next_user_id;
        $task->start_time = date('Y-m-d H:i:s');
        $task->status = 0;

        $ad->save(false);
        $task->save(false);
    }

    /**
     * @inheritdoc
     */
    public static function get_new_id_($id, $count) {




        $find = Ad::findOne(['custom_id' => $id]);
        if (!$find)
            return $id;

        return '---';

        //exit();
        //self::get_new_id_($id++, $count++);
    }

    public static function check_new_order($id = null, $resseler_id = null, $do_not_create = false) {

        if ($id)
            return Ad::findOne($id);

//$ch=Ad::find()->where

        if (!$resseler_id)
            $resseler_id = Yii::$app->user->id;

        if ($do_not_create)
            return null;


        $last_id = Ad::find()->orderBy(['id' => SORT_DESC])->one()->custom_id;

        //echo $last_id;
        $check = Ad::find()->where('resseler_id=' . $resseler_id . " and status=0 ")->orderBy(['id' => SORT_DESC])->One();
        if (!$check->id or $_GET['force_new']) {
            $m = new Ad();
            //$m->custom_id = ( self::get_new_id_($last_id + 1, 0) );
            $m->status = 0;
            $m->resseler_id = $resseler_id;
            $m->save(FALSE);
            return $m;
        } else {
            return $check;
        }
    }

    public function getCustomer() {
        return $this->hasOne(Customer::className(), ['id' => 'customer_id']);
    }

    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'resseler_id']);
    }

    private static function getseason() {
        $month = \common\models\Persian::gregorian_to_jalali(date("Y"), date('m'), date('d'))[1];
        $season = '';

        switch ($month) {
            case 1:
            case 2:
            case 3:
// echo 'It\'s Spring!';
                $season = 'فصل بهار';
                $season_id = 16;
                break;

            case 4:
            case 5:
            case 6:

// echo 'It\'s Summer!';
                $season = 'فصل تابستان';
                $season_id = 17;
                break;

            case 7:
            case 8:
            case 9:
//                echo 'It\'s Fall!';
                $season = 'فصل پاییز';
                $season_id = 18;
                break;

            case 10:
            case 11:
            case 12:
//                echo 'It must be Winter!';
                $season = 'فصل زمستان';
                $season_id = 19;
                break;
        }

        return $season_id;
    }

    public static function find_city($id) {
        $customer_table = Customer::find()->where(['id' => $id])->one();
        $ret = array();

        array_push($ret, $customer_table->city);
        return json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public static function get_customer_discount($id) {


        $this_season = Ad::getseason();
        $model_discount_season = DiscountItem::find()->where(['id' => $this_season])->one();
        $customer_table = Customer::find()->where(['id' => $id])->one();
////////////////////////////////////////اولین حضور

        $model_ad_date = Ad::find()->where(['customer_id' => $id])->orderBy(['date_publish' => SORT_DESC])->one();
//        print_r($model_ad_date);
        if ($model_ad_date) {
            $i = 5;
            while ($i > 0) {

                $date_one_year_ago = strtotime("-" . $i . " year", time());
                if (strtotime($model_ad_date->date) <= $date_one_year_ago) {
                    $final_date = $i;
                    break;
                } else {
                    $i -= 2;
                }
            }

            switch ($final_date) {
                case 1:
                    $first_present_discount = 4;
                    break;
                case 3:
                    $first_present_discount = 5;
                    break;
                case 5:
                    $first_present_discount = 6;
                    break;
            }

            $model_discount_present = DiscountItem::find()->where(['id' => $first_present_discount])->one();
        }
//////////////////////////////////////////////////////////////////////////////////////////////////////
/////////////////////////////////////////ضور مستمر

        $today_year = Persian::gregorian_to_jalali(date('Y'), date('m'), date('d'))[0];
        $temp_year = $today_year;

        $array_date = array();
        $has_active = 0;

        $j = 1;
        while ($j <= 4) {


            $temp_year = $today_year - $j;

            $first_day = Persian::convert_date_to_en($temp_year . "/01/01");
            $last_day = Persian::convert_date_to_en($temp_year . "/12/29");
            $active_ad = Ad::find()->where(['customer_id' => $id])->andWhere(['between', 'date_publish', $first_day, $last_day])->count();
//            echo $active_ad;
//            exit();
            if ($active_ad >= 10) {
                $has_active = $j;
            } else {
                break;
            }

            $j++;
        }

        switch ($has_active) {
            case 1:
                $continuous_present = 12;
                break;
            case 2:
                $continuous_present = 13;
                break;
            case 3:
                $continuous_present = 14;
                break;
            case 4:
                $continuous_present = 15;
                break;
        }

        $model_continuous_present = DiscountItem::find()->where(['id' => $continuous_present])->one();

/////////////////////////////////////////
////////////////////////تخفیف نوع مشتری

        $model_customer = \common\models\Customer::find()->select('discount_type')->where(['id' => $id])->one();
        $model_discount_type = DiscountItem::find()->where(['id' => $model_customer])->one();

////////////////////////////////////     
        $ret = array();
        $temp = array();

//تخفیف اولین حضور
        if ($model_discount_present) {
            $temp['id'] = $model_discount_present->id;
            $temp['value'] = $model_discount_present->discount;
            $temp['text'] = $model_discount_present->name;
            array_push($ret, $temp);
        }
// حضور مستمر
        if ($model_continuous_present) {
            $temp['id'] = $model_continuous_present->id;
            $temp['value'] = $model_continuous_present->discount;
            $temp['text'] = $model_continuous_present->name;
            array_push($ret, $temp);
        }
//discount_type مشتری
        if ($model_discount_type) {
            $temp['id'] = $model_discount_type->id;
            $temp['value'] = $model_discount_type->discount;
            $temp['text'] = $model_discount_type->name;
            array_push($ret, $temp);
        }
//خفیف فصلی
        if ($model_discount_season) {
            $temp['id'] = $model_discount_season->id;
            $temp['value'] = $model_discount_season->discount;
            $temp['text'] = $model_discount_season->name;
        }
        array_push($ret, $temp);
//        if ($customer_table->takhfif and $customer_table->temp_p_n) {
//            $temp['takhfif'] = $customer_table->takhfif;
//            $temp['temp'] = $customer_table->temp_p_n;
//            array_push($ret, $temp);
//        }
// print_r($ret);
        return json_encode($ret, JSON_UNESCAPED_UNICODE);
    }

    public function serial_check($attribute, $params) {

//$this->addError('customer_id',$this->date_publish);

        if ($this->serial) {
            $this->serial = ltrim($this->serial, '0');
            $serial_exists = Ad::find()->where(['serial' => ($this->serial)])->exists();
            if ($serial_exists) {
                $this->addError('serial', 'این شماره سریال قبلا ثبت شده است');
            }
        }
    }

    /**

      /**
     * @inheritdoc

      /**

      /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'date_publish2'=>'تاریخ انتشار دوم',
            'code_kargah'=>'کد کارگاهی',
            'vat' => 'مالیات بر ارزش افزوده',
            'custom_id' => 'شماره فاکتور',
            'pelekani' => 'تخفیف پلکانی',
            'inner_page_info' => 'عنوان صفحه داخلی آگهی',
            'cash_discount' => 'تخفیف نقدی',
            //'id' => 'شماره فاکتور',
            'discount_price' => 'تخفیفات',
            'serial' => 'سریال',
            'total_price' => 'قیمت کل قبل از تخفیف',
            'benefit_price' => 'کارمزد',
            'user_id' => 'ثبت کننده',
            'customer_id' => 'مشتری',
            'resseler_id' => 'کارگزار',
            'box_id' => 'صفحه',
            'box_price' => 'هزینه یک نوبت آگهی',
            //'total_price' => 'هزینه کل ۱ نوبت آگهی با ۱ کادر',
            'in_amount' => 'مبلغ قابل پرداخت ( ناخالص)',
            'title' => 'عنوان آگهی',
            'image' => 'تصویر آگهی',
            'naghdi_etebari' => 'نحوه پرداخت',
            'date' => 'تاریخ صدور فاکتور',
            'date_publish' => 'تاریخ انتشار آگهی',
            'box_qty' => 'تعداد کادر',
            'pub_qty' => 'تعداد نوبت ',
            'date_old_ad' => 'تاریخ چاپ قبلی',
            'number_page_oldad' => 'صفحات چپ قبلی',
            'status' => 'وضعیت ',
            'discount_rate' => 'درصد تخفیف',
            'inc_rate' => 'Inc Rate',
            'prev_credit' => 'Prev Credit',
            'price_credit' => 'Price Credit',
            'price_after_discount' => 'Price After Discount',
            'avl_credit' => 'Avl Credit',
            'benefit_rate' => 'Benefit Rate',
            'total_price_after_discount' => 'Total Price After Discount',
            'info' => 'توضیحات ',
            'ad_in_page' => 'آگهی در صفحه',
            'inc_rate' => 'درصد افزایشی',
            'price_after_discount' => 'قیمت بعد از تخفیف',
            'total_price_after_discount' => 'جمع کل بعد از تخفیف',
            'num_full_page' => 'تعداد تمام صفحه',
            'benefit_rate' => 'درصد کارمزد',
            'error' => 'دلیل رد آگهی',
            'document' => 'مدارک مورد نیاز',
            'file' => 'فایل آپلود',
            'tejari' => 'مدل آگهی',
            'benefit' => 'وضعیت کارمزد',
            'mali_attach' => 'فایل پیوست مالی',
            'mali_id' => 'نام کاربر مالی',
            'date1' => 'جستجو در تاریخ انتشار',
            'paziresh_id' => 'پذیرش',
            'customer_confirmation' => 'نیاز به تایید مشتری دارد؟ ',
            'ad_type' => 'نوع آگهی',
            'id_ad' => 'شناسه آگهی',
            'cer_no' => 'شماره مجوز',
            'contract_id' => 'شماره قرارداد',
            'fani' => 'توضیحات فنی',
            'in_the_time' => 'زمان ثبت آگهی',
            'logo' => 'آرم',
            'first_page' => 'صفحه اول',
            'gallery' => 'گالری',
            'pay_status' => 'وضعیت پرداخت',
            'takhfif_avalin_h_adi' => 'تخفیف اولین حضور عادی',
            'fix_discount'=>'تخفیف فیکس ریالی', 
            'takhfif_tarhim_tasliyat' => 'تخفیف ترحیم تسلیت',
            'd1' => 'تخفیف ۱',
            'd2' => 'تخفیف ۲',
            'd3' => 'تخفیف ۳',
            'd4' => 'تخفیف ۴',
            'b1' => 'کارمزد ۱',
            'b2' => 'کارمزد ۲',
            'b3' => 'کارمزد ۳',
            'b4' => 'کارمزد ۴',
        ];
    }

    public static function convert_number($number) {



        $ones = array("", "یک", 'دو&nbsp;', "سه", "چهار", "پنج", "شش", "هفت", "هشت", "نه", "ده", "یازده", "دوازده", "سیزده", "چهارده", "پانزده", "شانزده", "هفده", "هجده", "نونزده");
        $tens = array("", "", "بیست", "سی", "چهل", "پنجاه", "شصت", "هفتاد", "هشتاد", "نود");
        $tows = array("", "صد", "دویست", "سیصد", "چهار صد", "پانصد", "ششصد", "هفتصد", "هشت صد", "نه صد");

        if (($number < 0) || ($number > 999999999999)) {
            throw new \Exception("Number is out of range");
        }

        $Bi = floor($number / 1000000000);
        /* Thousands (kilo) */
        $number -= $Bi * 1000000000;

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
        if ($Bi) {
            $res .= Ad::convert_number($Bi) . " میلیارد و ";
        }
        if ($Gn) {
            $res .= Ad::convert_number($Gn) . " میلیون و ";
        }
        if ($kn) {
            $res .= (empty($res) ? "" : " ") . Ad::convert_number($kn) . " هزار و";
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

    public function getUserHasAd() {
        return $this->hasMany(UserHasAd::className(), ['model_id' => 'id']);
    }

    public function getDisc() {
        return $this->hasMany(AdHasDiscount::className(), ['ad_id' => 'id']);
    }

    public function getBox() {
        return $this->hasOne(Box::className(), ['id' => 'box_id']);
    }

    public static function getTotal($provider, $fieldName) {
        $total = 0;

        foreach ($provider as $item) {
            $total += $item[$fieldName];
        }

        return $total;
    }

    public static function get_type_price($ad_type, $box_id, $pub_date, $increase = null) {

        //echo "(".$ad_type."~<br>";
        // if($naghdi_etebari==4)
        //     return 0;

        $ad_type = AdType::findOne($ad_type);

        //echo $pub_date."*";
        if (strpos($pub_date, '۱۳۹۹') !== false or strpos($pub_date, '1399') !== false) {
            $ex = "99";
        }

        if ($ad_type->price_type) {

            //echo $ad_type->price_type;
            //echo  \common\models\Box::findOne($box_id)->price_dolati;

            switch ($ad_type->price_type) {

                case 1:
                    $price = \common\models\Box::findOne($box_id)->{'price' . $ex};
                    break;
                case 2:
                    $price = \common\models\Box::findOne($box_id)->{'price_sabti' . $ex};
                    break;
                case 3:
                    $price = \common\models\Box::findOne($box_id)->{'price_dolati' . $ex};
                    break;
            }
        } else {
            $price = \common\models\Box::findOne($box_id)->{'price' . $ex};
        }

        if ($increase) {
            $price *= 1 + ($increase / 100);
        }


        return $price;
    }

    public static function check_all_un_paid_ads() {

        foreach (\common\models\Ad::find()->where(['pay_status' => 0])->all() as $a) {

            if ($a->naghdi_etebari == 1) {
                //echo "H1";
                $needed = ($a->in_amount - $a->benefit_price) - $a->cash;
            } elseif ($a->naghdi_etebari == 2 or $a->naghdi_etebari == 3) {
                $needed = ($a->in_amount) - $a->cash;
            }

            if ($a->vat)
                $needed += $a->in_amount *  VatYear::vatfinder($a);

            //echo $needed."\n";
            if ($needed <= 1) {
                $a->pay_status = 1;
                $a->save();

                if ($a->naghdi_etebari == 2) {
                    $a->user->wallet += ( $a->benefit_price);
                    $a->user->save();
                }
            }
        }
    }

}
