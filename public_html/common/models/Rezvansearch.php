<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Rezvan;

/**
 * Rezvansearch represents the model behind the search form of `common\models\Rezvan`.
 */
class Rezvansearch extends Rezvan {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'ad_id', 'user_id'], 'integer'],
            [['gallery'], 'safe'],
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
    public function search($params, $id = null) {
        $query = Rezvan::find();

        // add conditions that should always apply here
        if ($id) {
            $query->andWhere(['ad_id' => $id]);
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
            'ad_id' => $this->ad_id,
            'user_id' => $this->user_id,
        ]);

        $query->andFilterWhere(['like', 'gallery', $this->gallery]);

        return $dataProvider;
    }

}
