<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_has_discount".
 *
 * @property integer $ad_id
 * @property integer $discount_id
 * @property string $discount_rate
 * @property string $discount_price
 * @property string $inc_rate
 */
class AdHasDiscount extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'ad_has_discount';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['ad_id', 'discount_id', 'discount_rate',], 'required'],
            [['ad_id', 'discount_id'], 'integer'],
            [['discount_rate', 'discount_price', 'inc_rate', 'discount_price', 'inc_rate'], 'safe',],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'ad_id' => 'Ad ID',
            'discount_id' => 'Discount ID',
            'discount_rate' => 'Discount Rate',
            'discount_price' => 'Discount Price',
            'inc_rate' => 'Inc Rate',
        ];
    }
    
    public function getDiscount()
    {
        return $this->hasOne(DiscountItem::className(), ['id' => 'discount_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Ad::className(), ['id' => 'ad_id']);
    }

}
