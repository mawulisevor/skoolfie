<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Student;

/**
 * StudentSearch represents the model behind the search form about `frontend\models\Student`.
 */
class StudentSearch extends Student
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['studid', 'lname', 'mname', 'oname', 'progid', 'sex', 'phone', 'email', 'admdate', 'birthdate', 'gradgroup', 'certclass', 'picture'], 'safe'],
            [['currentlevel', 'admissionlevel', 'semsdone', 'totalcredit'], 'integer'],
            [['totalgp', 'cgpa'], 'number'],
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
        $query = Student::find();

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
            'currentlevel' => $this->currentlevel,
            'admissionlevel' => $this->admissionlevel,
            'admdate' => $this->admdate,
            'birthdate' => $this->birthdate,
            'semsdone' => $this->semsdone,
            'totalgp' => $this->totalgp,
            'totalcredit' => $this->totalcredit,
            'cgpa' => $this->cgpa,
        ]);

        $query->andFilterWhere(['like', 'studid', $this->studid])
            ->andFilterWhere(['like', 'lname', $this->lname])
            ->andFilterWhere(['like', 'mname', $this->mname])
            ->andFilterWhere(['like', 'oname', $this->oname])
            ->andFilterWhere(['like', 'progid', $this->progid])
            ->andFilterWhere(['like', 'sex', $this->sex])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'gradgroup', $this->gradgroup])
            ->andFilterWhere(['like', 'certclass', $this->certclass])
            ->andFilterWhere(['like', 'picture', $this->picture]);

        return $dataProvider;
    }
}
