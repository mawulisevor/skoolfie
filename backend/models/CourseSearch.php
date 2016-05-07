<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Course;

/**
 * CourseSearch represents the model behind the search form about `backend\models\Course`.
 */
class CourseSearch extends Course
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['courseid', 'coursename', 'progid'], 'safe'],
            [['coursecredit', 'aclevel', 'semester', 'deptid'], 'integer'],
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
        $query = Course::find();

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
            'coursecredit' => $this->coursecredit,
            'aclevel' => $this->aclevel,
            'semester' => $this->semester,
            'deptid' => $this->deptid,
        ]);

        $query->andFilterWhere(['like', 'courseid', $this->courseid])
            ->andFilterWhere(['like', 'coursename', $this->coursename])
            ->andFilterWhere(['like', 'progid', $this->progid]);

        return $dataProvider;
    }
}
