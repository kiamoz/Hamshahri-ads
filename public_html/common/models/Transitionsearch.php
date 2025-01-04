<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Transition;

/**
 * Transitionsearch represents the model behind the search form of `common\models\Transition`.
 */
class Transitionsearch extends Transition
{
    /**
     * {@inheritdoc}
     */
    
    public  $date1,$date2;


    public function rules()
    {
        return [
            [['id', 'amount', 'user_id', 'ad_id', 'etebar', 'actor_id'], 'integer'],
            [['date', 'type','user_id','detail','sanad','resid','date1','date2'], 'safe'],
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
        
        // print_r($params);
         
        $query = Transition::find()->orderBy(['id' => SORT_DESC]);

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
            'date' => $this->date,
            'amount' => $this->amount,
            'user_id' => $this->user_id,
            'ad_id' => $this->ad_id,
            'etebar' => $this->etebar,
            'actor_id' => $this->actor_id,
            'sanad'=>$this->sanad,
            'resid'=>$this->resid,
        ]);

        $query->andFilterWhere(['like', 'type', $this->type]);
        $query->andFilterWhere(['like', 'detail', $this->detail]);
        
         if ($this->date2 and $this->date1) {

            // echo $this->date2." ".$this->date1;
            $date_x = \common\models\Persian::convert_date_to_en(Persian::persian_digit_replace($this->date1));
            //echo $date_x."<br>";
            $date_y = \common\models\Persian::convert_date_to_en(Persian::persian_digit_replace($this->date2));

            $query->andWhere(['between', 'date', $date_x, $date_y]);
        }

        return $dataProvider;
    }
}
