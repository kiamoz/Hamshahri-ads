<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Customer;

/**
 * CustomerSearch represents the model behind the search form about `common\models\Customer`.
 */
class CustomerSearch extends Customer {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
                [['id', 'owner_id', 'social_code', 'addres'], 'integer'],
                [['name', 'city', 'phone', 'postal_code'], 'safe'],
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
    public function search($params, $lvl) {
        $query = Customer::find();

        // add conditions that should always apply here
        if ($lvl == 8)
            $query->orderBy(['id' => SORT_ASC]);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
        // $query = Ad::find()->where(['customer_id'=>$model->id]);
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        if (2 > 3) {
            $query->andWhere(['reseller_id' => Yii::$app->user->id]);
        }


        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
           
            'social_code' => $this->social_code,
            'addres' => $this->addres,
            'economical_code' => $this->economical_code,
        ]);

        $query
                ->andFilterWhere(['like', 'city', $this->city])
                ->andFilterWhere(['like', 'phone', $this->phone])
                ->andFilterWhere(['like', 'postal_code', $this->postal_code])
                ->andFilterWhere(['like', 'name', $this->name]);



        return $dataProvider;
    }

}
