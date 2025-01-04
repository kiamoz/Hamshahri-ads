<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Document;

/**
 * Documentsearch represents the model behind the search form of `common\models\Document`.
 */
class Documentsearch extends Document {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'customer_id'], 'integer'],
            [['subject', 'file'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
    public function search($params, $just_me=false, $ad_id=false) {
        $query = Document::find();
        // add conditions that should always apply here
        if ($just_me)
            $query->andWhere(['customer_id' => $just_me]);
        
         if ($ad_id){
            $query->andWhere(['ad_id' => $ad_id]);
         }
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
            'customer_id' => $this->customer_id,
        ]);

        $query->andFilterWhere(['like', 'subject', $this->subject])
                ->andFilterWhere(['like', 'file', $this->file]);

        return $dataProvider;
    }

}
