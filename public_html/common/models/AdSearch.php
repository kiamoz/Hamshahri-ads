<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Ad;
use common\models\Design;

/**
 * AdSearch represents the model behind the search form about `common\models\Ad`.
 */
class AdSearch extends Ad {

    /**
     * @inheritdoc
     */
    public $date1;
    public $date2;
    public $name;
    public $status_text;
    public $status_task, $benefit___,$economical_code,$social_code,$postal_code,$addres,$phone;
    
    //public 

    public function rules() {
        return [
            [['id', 'box_qty', 'pub_qty', 'serial', 'resseler_id'], 'integer'],
            [['status', 'date1', 'date2', 'ad_type', 'disc___', 'naghdi_etebari', 'benefit___', 'box_price', 'total_price', 'discount_price', 'in_amount', 'benefit_price', 'pay_status', 'custom_id'], 'safe'],
            [['user_id',
                
                'economical_code','social_code','postal_code','addres','phone',
                'customer_id', 'resseler_id', 'box_id', 'box_price', 'total_price', 'in_amount', 'title', 'image', 'date', 'date_publish', 'date_old_ad', 'number_page_oldad', 'custom_id'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $just_me = false, $ad_id = false, $customer_id = null, $ad_id_ = null, $benefit = null, $kargozar = false, $kargozar_mah = false, $r = false, $date = false, $month = false, $pay_status = null) {


        //print_r($params);

        $query = Ad::find()->joinWith('customer');
        
        

        if (!$params['sort'])
            $query->orderBy(['id' => SORT_DESC]);


        //print_r($params);
//        $query->leftJoin('ad_has_discount', 'ad_id=id')
//                ->andWhere(['is', 'ad_has_discount.ad_id', NULL]);
//        echo $query->createCommand()->rawSql . "*******************************";
        //if (count($params) == 2)
        //    $query = Ad::find()->orderBy(['date' => SORT_DESC]);

        if ($just_me) {
            $query->andWhere(['resseler_id' => Yii::$app->user->identity->id]);
        }

        if ($pay_status == "0") {
            $query->andWhere(['pay_status' => 0]);
        }
        if ($pay_status == 1) {
            $query->andWhere(['pay_status' => 1]);
        }
//        if ($just_me) {
//            $query->andWhere(['resseler_id' => Yii::$app->user->identity->id, 'benefit' => $benefit]);
//        }
        if ($kargozar) {
            $query->andWhere(['resseler_id' => $kargozar]);
        }
        if ($benefit) {
            $query->andWhere(['benefit' => $benefit]);
        }
        if ($kargozar_mah) {
            $date = \common\models\Persian::get_current_month_array();
            $date = (explode(" ", $date));
            $user_online = Yii::$app->user->identity->id;

            $query->andWhere(['resseler_id' => $user_online])->andWhere(['between', 'date_publish', $date[1], $date[0]])->all();
        }
        if ($_GET['semahe'] == 1) {
            $query->andWhere(['>', 'serial', '0']);
        }
        if ($customer_id) {
            $query->andWhere(['customer_id' => $customer_id]);
        }
        if ($r) {

            $query->select('benefit_price,resseler_id,cash,in_amount,sum(in_amount) as sum_in_amount,sum(benefit_price) as sum_benefit_price');
            $query->groupBy('resseler_id');
        }

        if ($date) {
            $date = date('Y-m-d');
            $query->andWhere(['date_publish' => $date]);
            //$query->groupBy(['date']);
        }
        if ($month) {
            $date = date('Y-m-d');
            $date1 = \common\models\Persian::get_current_month();
            $query->andWhere(['between', 'date_publish', $date1, $date]);
            $s_khales = 0;
            $s_nakhales = 0;
            $s_benefit = 0;
            foreach ($query as $kh) {
                $s_khales += (($kh->in_amount) - ($kh->benefit_price));
                $s_nakhales += $kh->in_amount;
                $s_benefit += $kh->benefit_price;
            }
        }
        // add conditions that should always apply here
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if ($this->name) {
            $query->andFilterWhere(['name' => $this->name]);
        }
        if ($this->status) {
            $query->andFilterWhere(['ad.status' => $this->status]);
        }
        if ($this->resseler_id) {
            $query->andFilterWhere(['resseler_id' => $this->resseler_id]);
        }

//         $query1 = Design::find()->orderBy(['ad_id' => SORT_DESC]);
//         if ($this->ad_id) {
//            $query->andFilterWhere(['status' => $this->status]);
//        }
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if ($this->disc___) {
            $query->innerJoinWith('disc');
            $query->andFilterWhere([
                'discount_id' => $this->disc___,
            ]);
        }

        if ($this->benefit___) {
            $query->innerJoinWith('disc');
            $query->andFilterWhere([
                'discount_id' => $this->benefit___,
            ]);
        }



        // grid filtering conditions
        $query->andFilterWhere([
            'ad.id' => $this->id,
            'box_qty' => $this->box_qty,
            'serial' => $this->serial,
            'pub_qty' => $this->pub_qty,
            'customer_id' => $this->customer_id,
            'resseler_id' => $this->resseler_id,
            'ad_type' => $this->ad_type,
            'naghdi_etebari' => $this->naghdi_etebari,
            //'date_publish'=>$this->naghdi_etebari,
            'box_price' => $this->box_price,
            'total_price' => $this->total_price,
            'discount_price' => $this->discount_price,
            'in_amount' => $this->in_amount,
            'benefit_price' => $this->benefit_price,
            'pay_status' => $this->pay_status,
            'custom_id' => $this->custom_id,
            'customer.phone'=> $this->phone,
            'customer.addres'=> $this->addres,
            'customer.postal_code'=> $this->postal_code,
            'customer.economical_code'=> $this->economical_code,
            'customer.social_code'=> $this->social_code,
        ]);
        //$query->andWhere(['>','in_amount',0]);
        //echo $query->createCommand()->rawSql;
        //exit();



        $query->andFilterWhere(['like', 'user_id', $this->user_id])
                ->andFilterWhere(['like', 'box_id', $this->box_id])
                ->andFilterWhere(['like', 'box_price', $this->box_price])
                ->andFilterWhere(['like', 'total_price', $this->total_price])
                ->andFilterWhere(['like', 'in_amount', $this->in_amount])
                // ->andFilterWhere(['like', 'custom_id', $this->custom_id])
                ->andFilterWhere(['like', 'title', $this->title])
                ->andFilterWhere(['like', 'image', $this->image])
                ->andFilterWhere(['like', 'date', $this->date])
                ->andFilterWhere(['like', 'date_old_ad', $this->date_old_ad])
                ->andFilterWhere(['like', 'number_page_oldad', $this->number_page_oldad]);

        if ($this->date2 and $this->date1) {

            // echo $this->date2." ".$this->date1;
            $date_x = \common\models\Persian::convert_date_to_en(Persian::persian_digit_replace($this->date1));
            //echo $date_x."<br>";
            $date_y = \common\models\Persian::convert_date_to_en(Persian::persian_digit_replace($this->date2));

            $query->andWhere(['between', 'ad.date_publish', $date_x, $date_y]);
        }
        //$query->groupBy('ad.id');
//echo $query->createCommand()->getrawSql();

        return $dataProvider;
    }

}
