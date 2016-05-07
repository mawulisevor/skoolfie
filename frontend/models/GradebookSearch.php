<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use frontend\models\Gradebook;

/**
 * StudentSearch represents the model behind the search form about `app\models\Student`.
 */
class GradebookSearch extends Gradebook
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Index_No','Course_Code','Year'], 'safe'],
            [['Ac_Level', 'Semester'], 'integer'],
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
        $query = Gradebook::find();

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
            'Index_No' => $this->Index_No,
            'Course_Code' => $this->Course_Code,
            'Year' => $this->Year,
            'Ac_Level' => $this->Ac_Level,
            'Semester' => $this->Semester,            
        ]);

        return $dataProvider;
    }
}
