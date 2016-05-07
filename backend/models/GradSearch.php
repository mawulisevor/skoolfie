<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\db\Command;
use yii\db;
use yii\db\Connection;
use yii\data\ActiveDataProvider;

/**
 * GradSearch represents the model behind the search form about `app\models\Student`.
 */


class GradSearch extends Student
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['gradgroup',], 'safe'],
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
        $query = new Query;
        $query -> select('gradgroup')->distinct()->from('student');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'gradgroup', $this->gradgroup]);

        return $dataProvider;
    }
}
