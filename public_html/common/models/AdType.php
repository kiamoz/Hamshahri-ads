<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "ad_type".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 * @property string $benefit_json
 * @property string $discount_json
 */
class AdType extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ad_type';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','price_type'], 'required'],
            [['parent_id'], 'integer'],
            [['benefit_json','discount_json','shaba'], 'safe'],
            [['name'], 'string', 'max' => 2222],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'نام نوع درآمد',
            'parent_id' => 'بالاسری',
            'benefit_json' => 'کارمزد ها',
            'discount_json'=>' تخفیف ها',
        ];
    }
}
