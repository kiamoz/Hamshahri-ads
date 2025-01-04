<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserS represents the model behind the search form about `common\models\User`.
 */
class UserS extends User {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name_and_fam', 'id', 'username', 'password_hash', 'cell_number', 'phone_number', 'social_code', 'postal_code', 'sh_number', 'file', 'code_kargozar','status_p'], 'safe'],
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
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'resseler_id']);
    }

    public function search($params, $type) {


        $query = User::find();

        if ($type == 1)
            $query->where('type=8');

        if ($type == 2) {

            $query->andWhere(['>', 'lvl', 0])->andWhere(['<', 'lvl', 8])->orWhere(['lvl' => 22])->orWhere(['type' => 2])->orderBy(['lvl' => SORT_ASC]);
        }
        
        if ($type == 2) {

            $query->orWhere(['lvl' => 9])->orderBy(['lvl' => SORT_ASC]);
        }
        if ($type == 8) {

            $query->andWhere(['lvl' => 8])->orderBy(['code_kargozar' => SORT_ASC]);
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
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'code_kargozar' => $this->code_kargozar,
               'status_p' => $this->status_p,
        ]);

        $query->andFilterWhere(['like', 'name_and_fam', $this->name_and_fam])
                ->andFilterWhere(['like', 'username', $this->username])
                ->andFilterWhere(['like', 'auth_key', $this->auth_key])
                ->andFilterWhere(['like', 'password_hash', $this->password_hash])
                ->andFilterWhere(['like', 'email', $this->email])
                ->andFilterWhere(['like', 'cell_number', $this->cell_number])
                ->andFilterWhere(['like', 'phone_number', $this->phone_number])
                ->andFilterWhere(['like', 'social_code', $this->social_code])
               
                ->andFilterWhere(['like', 'postal_code', $this->postal_code])



        ;
        
        
        //echo $query->createCommand()->getRawSql();

        return $dataProvider;
    }

}
