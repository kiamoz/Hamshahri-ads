<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Task;

/**
 * Tasksearch represents the model behind the search form of `common\models\Task`.
 */
class Tasksearch extends Task {

    /**
     * {@inheritdoc}
     */
    public function rules() {
        return [
            [['id', 'user_id', 'status', 'model_id'], 'integer'],
            [['start_time'], 'safe'],
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
    public function search($params, $just_me = false, $ad_id = false, $report = false) {
        $query = Task::find()->orderBy(['id' => SORT_DESC]);

        if ($ad_id)
            $query->andWhere(['model_id' => $ad_id]);
        if ($report) {
            $now = date('Y-m-d');
            $yesterday = date('Y-m-d H:i:s', strtotime('-1 day', strtotime($now)));
           
          //   echo 'yester' . $yesterday . '<br>';
      
            $query->andWhere(['user_id' => Yii::$app->user->identity->id])->andWhere(['LIKE', 'start_time', $now]) ;
          //  echo $query->createCommand()->rawSql;
        }
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
            'user_id' => $this->user_id,
            'start_time' => $this->start_time,
            'end_time' => $this->end_time,
            'status' => $this->status,
                // 'model_id' => $this->ad_id,
        ]);

        return $dataProvider;
    }

}
