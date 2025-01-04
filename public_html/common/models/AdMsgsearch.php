<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\AdMsg;

/**
 * AdMsgsearch represents the model behind the search form of `common\models\AdMsg`.
 */
class AdMsgsearch extends AdMsg
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'ad_id', 'internal', 'task_id'], 'integer'],
            [['date'], 'safe'],
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
    public function search($params,$ad_id)
    {
        $query = AdMsg::find();

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
            'date' => $this->date,
            'internal' => $this->internal,
            'task_id' => $this->task_id,
        ]);

        return $dataProvider;
    }
}
