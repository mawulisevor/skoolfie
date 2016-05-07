<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Admissionresult;

/**
 * AdmissionresultSearch represents the model behind the search form about `backend\models\Admissionresult`.
 */
class AdmissionresultSearch extends Admissionresult
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['studid', 'cert', 'institution', 'certno', 'indexno', 'certclass', 'subject', 'grade'], 'safe'],
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
        $query = Admissionresult::find();

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
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'studid', $this->studid])
            ->andFilterWhere(['like', 'cert', $this->cert])
            ->andFilterWhere(['like', 'institution', $this->institution])
            ->andFilterWhere(['like', 'certno', $this->certno])
            ->andFilterWhere(['like', 'indexno', $this->indexno])
            ->andFilterWhere(['like', 'certclass', $this->certclass])
            ->andFilterWhere(['like', 'subject', $this->subject])
            ->andFilterWhere(['like', 'grade', $this->grade]);

        return $dataProvider;
    }
}
