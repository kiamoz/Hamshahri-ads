<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Design;

/**
 * Designsearch represents the model behind the search form of `common\models\Design`.
 */
class Designsearch extends Design
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ad_id', 'tarahi_id', 'status'], 'integer'],
            [['attach', 'why_reject'], 'safe'],
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
    public function search($params,$ad_id=false)
    {
        $query = Design::find()->orderBy(['id'=>SORT_DESC]);

        // add conditions that should always apply here
        if($ad_id)
             $query->andWhere(['ad_id'=>$ad_id]); 
 
 
 
 
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
            'ad_id' => $this->ad_id,
            'tarahi_id' => $this->tarahi_id,
            'status' => $this->status,
        ]);

        $query->andFilterWhere(['like', 'attach', $this->attach])
            ->andFilterWhere(['like', 'why_reject', $this->why_reject]);

        return $dataProvider;
    }
}
