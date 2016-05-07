<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Academicyear;

/**
 * AcademicyearSearch represents the model behind the search form about `backend\models\Academicyear`.
 */
class AcademicyearSearch extends Academicyear
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['acyear', 'description', 'startdate', 'enddate'], 'safe'],
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
        $query = Academicyear::find();

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
            'startdate' => $this->startdate,
            'enddate' => $this->enddate,
        ]);

        $query->andFilterWhere(['like', 'acyear', $this->acyear])
            ->andFilterWhere(['like', 'description', $this->description]);

        return $dataProvider;
    }
}
