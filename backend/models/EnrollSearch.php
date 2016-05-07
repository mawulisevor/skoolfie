<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Enroll;

/**
 * EnrollSearch represents the model behind the search form about `backend\models\Enroll`.
 */
class EnrollSearch extends Enroll
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['studid', 'courseid', 'acyear'], 'safe'],
            [['ca', 'exams', 'classroom'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
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
        $query = Enroll::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'ca' => $this->ca,
            'exams' => $this->exams,
            'classroom' => $this->classroom,
        ]);

        $query->andFilterWhere(['like', 'studid', $this->studid])
            ->andFilterWhere(['like', 'courseid', $this->courseid])
            ->andFilterWhere(['like', 'acyear', $this->acyear]);

        return $dataProvider;
    }
}
