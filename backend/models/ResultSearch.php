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
 * ResultSearch represents the model behind the search form about `app\models\Result`.
 */


class ResultSearch extends Result
{
    /**
     * @inheritdoc
     */

    public function rules()
    {
        return [
            [['Year','Level','Semester'], 'safe'],
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
        $query -> select('Year,Level,Semester')->distinct()->from('result');

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
            'Year' => $this->Year,
            'Level' => $this->Level,
            'Semester' => $this->Semester,
        ]);



        return $dataProvider;
    }
}
