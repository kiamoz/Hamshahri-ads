<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "discount_item".
 *
 * @property integer $id
 * @property string $name
 * @property string $cat_id
 * @property string $discount
 */
class DiscountItem extends \yii\db\ActiveRecord {

    const discount_table = array(
        1 => 'پله اول ',
        2 => 'پله دوم ',
    );
    
    

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'discount_item';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'discount','just_discount'], 'required'],
           
            [['name', 'cat_id', 'discount', 'type', ''], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'شناسه',
            'name' => 'نام تخفیف',
            'cat_id' => 'دسته بندی ',
            'type' => 'تخفیف یا کارمزد',
            'discount' => 'درصد تخفیف',
            'just_discount' => 'فقط تخفیف بدون افزایش اعتبار تخفیف خالص حتا در پلکان اول'
        ];
    }

}
