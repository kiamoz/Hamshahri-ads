<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface {

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    const type_id_status = array(
        22 => 'رضوان--',
        1 => 'سوپروایزر',
        2 => 'پذیرش ',
        3 => 'رئیس دبیری ',
        4 => 'ماکت ',
        5 => 'طراحی ',
        6 => 'دبیری',
        9 => 'مالی',
        10 => 'چاپ شده',
    );
    const customer_confirmation = array(
        1 => 'بله',
        0 => 'خیر',
    );
    const type_id_text = array(
        1 => 'سوپروایزر ',
        2 => 'پذیرش ',
        3 => 'رئیس دبیری ',
        4 => 'ماکت ',
        5 => 'طراحی ',
        6 => 'دبیری',
        8 => 'کارگزار ',
        9 => 'مالی',
        22 => 'رضوان---',
    );
    const data_status = array(
        10 => 'فعال',
        9 => 'غیرفعال',
    );
    const data_status_customer = array(
        1 => 'فعال',
        0 => 'غیرفعال',
    );
    const access_list = array(
        1 => 'دیدن نوع فاکتور',
        2 => 'ویرایش نوع فاکتور',
        3 => 'حذف نوع فاکتور',
        4 => 'دیدن تعرفه',
        5 => 'ویرایش تعرفه',
        6 => 'حذف تعرفه',
        7 => 'دیدن درآمد ها',
        8 => 'ویرایش درآمد ها',
        9 => 'حذف درآمد ها',
        10 => 'دیدن تخفیف و کارمزد ها',
        11 => 'ویرایش تخفیف و کارمزد ها',
        12 => 'حذف تخفیف و کارمزد ها',
        13 => 'لیست کاربران سیستم',
        14 => 'ویرایش کاربران سیستم',
        15 => 'حذف کاربران سیستم',
        16 => 'لیست کارگزاران سیستم',
        17 => 'ثبت و ویرایش کارگزاران سیستم',
        18 => 'حذف کارگزاران سیستم',
        19 => 'ثبت آگهی برای کارگزاران سیستم',
        20 => 'لیست مشتریان سیستم',
        21 => 'ویرایش مشتریان سیستم',
        22 => 'حذف مشتریان سیستم',
        23 => 'نمایش تمام آگهی ها و گزارشات روکش',
        24 => 'ویرایش تمام آگهی',
        25 => 'باطل کردن تمام آگهی ها',
        100 => 'دسترسی مالی و گزاراشت',
        101 => 'دیدن گردش های مالی',
        102 => 'ثبت گردش مالی',
        104 => 'نمایش روکش',
        105 => 'گزارش فصلی',
        106 => 'دسترسی تغییر کارگزار و تغییر شماره فاکتور',
    );
    const transition_list = array(
        'new ad' => '1',
        'etebar' => '2',
        'offline' => '3',
        'online' => '4',
        'reduce_qty' => '5',
        'edit ad' => '6',
    );
    const list_transition = array(
        1 => 'ثبت آگهی جدید نقدی',
        2 => 'ثبت آگهی جدید اعتباری',
        3 => 'ثبت آگهی جدید تهادر',
        //2 => 'اعتبار',
        // 3 => 'آفلاین',
        //4 => 'پرداخت آنلاین',
        5 => 'تغییر بدهی اعتباری',
        6 => 'تغییر بدهی نقدی',
        7 => 'تغییر مبلغ کیف پول',
        8 => 'تغییر بدهی تهاتر',
        9 => 'پرداخت  آگهی های اعتباری',
        10 => 'برداشت از موجودی نقدی',
        11 => 'حواله',
        12 => 'چک نقد نشده  ',
        13 => 'چک  ',
        14 => 'چک روز',
        15 => 'واریزی به حساب  کارگزار',
        100 => 'استفاده از کیف پول کارگزار',
        101 => 'استفاده از معادل ریالی تهاتر کارگزار',
        102 => 'برگشت زدن مبلغ پرداخت شده آگهی به کیف پول',
    );
    const list_transition_icon = array(
        1 => '<i class="icon-arrow-down-circle"></i>',
        2 => '<i class="icon-arrow-down-circle"></i>',
        3 => '<i class="icon-arrow-down-circle"></i>',
//        5 => '<i class="icon-arrow-up-circle"></i>',
//        6 => '<i class="icon-arrow-down-circle"></i>',
//        7 => '<i class="icon-arrow-up-circle"></i>',
        8 => '<i class="icon-arrow-down-circle"></i>',
        // 3 => 'آفلاین',
        4 => '<i class="icon-arrow-up-circle"></i>',
        11 => '<i class="icon-arrow-up-circle"></i>',
        12 => '<i class="icon-arrow-up-circle"></i>',
        100 => '<i class="icon-arrow-down-circle"></i>',
        15 => '<i class="icon-arrow-down-circle"></i>',
    );

    /**
     * @inheritdoc
     */
    public $password, $recommender_email;

    public static function tableName() {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return [
            TimestampBehavior::className(),
        ];
    }

    public function rules() {


        return[
            [['username'], 'unique'],
            [['name_and_fam'], 'must_unique', 'on' => 'kar'],
            [['username', 'address', 'phone_number'], 'required', 'on' => 'kar'],
            [['username', 'status', 'name_and_fam'], 'required'],
            [['id', 'etebar', 'credit', 'saghf_etebar', 'status_p', 'addres_work', 'karmozd', 'etebar_naghdi', 'credit_naghdi', 'saghf_etebar_naghdi', 'benefit_override'], 'safe'],
            [['company_name', 'password', 'password_hash', 'code_kargozar', 'kargozar_id', 'level_id', 'sh_gharardad', 'username', 'email', 'cell_number', 'phone_number', 'social_code', 'postal_code', 'address', 'recommender_email', 'sms_token', 'benefit_type', 'benefit_value', 'lvl', 'fax', 'code_eghtesadi', 'tarikh_gharardad', 'city', 'sub_type', 'prev_naghdi', 'prev_etebari'], 'safe'],
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['name_and_fam', 'check_code', 'on' => 'kar']
        ];
    }

    public function check_code($attribute, $params) {




        if (!$this->social_code and!$this->code_eghtesadi) {
            $this->addError('social_code', 'واردکرد کد اقتصاید یا کد ملی / شناسه ملی اجباری است');
            return false;
        }
    }

    public function attributeLabels() {
        return [
            'id' => 'شناسه ',
            'benefit_type' => 'نوع سهم سود ',
            'benefit_value' => 'مقدار سهم سود ',
            'type_id' => 'گروه بندی دسترسی',
            'name_and_fam' => 'نام و نام خانوادگی',
            'username' => 'حساب کاربری(شماره همراه یا کد کارگزار) ',
            'email' => 'آدرس ایمیل ',
            'cell_number' => 'شماره تلفن همراه ',
            'phone_number' => 'شماره های تماس ',
            'social_code' => 'کد ملی/شناسه ملی ',
            'postal_code' => 'کد پستی ',
            'status' => 'وضعیت کاربر ',
            'password' => 'گذرواژه',
            'company_name' => 'نام شرکت',
            'tarikh_gharardad' => 'تاریخ قرارداد',
            'sh_gharardad' => 'شماره قرارداد',
            'code_kargozar' => 'کد کارگزار',
            'lvl' => 'گروه بندی',
            'address' => 'آدرس',
            'fax' => 'فکس',
            'code_eghtesadi' => 'کد اقتصادی',
            'etebar' => 'فعال بود بدهکاری اعتباری',
            'level_id' => 'سطح دسترسی',
            'saghf_etebar' => 'سقف بدهکاری اعتباری',
            'credit' => 'مانده  اعتباری',
            'credit_naghdi' => 'مانده  نقدی',
            'addres_work' => 'آدرس محل کار',
            'status_p' => '',
            'karmozd' => ' ثبت آگهی بدون کارمزد  ',
            'etebar_naghdi' => 'فعال بودن بدهکاری نقدی',
            'saghf_etebar_naghdi' => 'سقف بدهکاری نقدی',
            'type' => 'نوع کاربر',
            'sub_type' => 'ثبت آگهی دولتی',
            'inc_khareji' => 'افزایش تعرفه خارجی',
            'benefit_override' => 'تغییر کارمزد پیش فرض',
            'prev_etebari' => 'مانده اول دوره اعتباری',
            'prev_naghdi' => 'مانده اول دوره نقدی',
            'credit_tahator' => 'مانده تهاتر',
        ];
    }

    public function must_unique($attribute, $params) {
        $cust_table = User::find()->where(['name_and_fam' => $this->name_and_fam, 'lvl' => 8])->one();
//      print_r($cust_table);
//      exit();
        if ($cust_table) {
            $this->addError($attribute, 'نام تکراری است');
            return false;
        } else {
            return true;
        }
    }

    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return bool
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int) substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

}
