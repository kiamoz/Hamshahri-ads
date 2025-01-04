<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\CustomerDuration;

/**
 * CustomerDurationsearch represents the model behind the search form of `common\models\CustomerDuration`.
 */
class CustomerDurationsearch extends CustomerDuration
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kargozar_id', 'customer_id'], 'integer'],
            [['name_customer', 'date'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
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
    public function search($params)
    {
        $query = CustomerDuration::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'kargozar_id' => $this->kargozar_id,
            'customer_id' => $this->customer_id,
            'date' => $this->date,
        ]);

        $query->andFilterWhere(['like', 'name_customer', $this->name_customer]);

        return $dataProvider;
    }
}
