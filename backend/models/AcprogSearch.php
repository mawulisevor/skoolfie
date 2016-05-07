<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Acprog;

/**
 * AcprogSearch represents the model behind the search form about `backend\models\Acprog`.
 */
class AcprogSearch extends Acprog
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['progid', 'progname', 'awardedby'], 'safe'],
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
        $query = Acprog::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'progid', $this->progid])
            ->andFilterWhere(['like', 'progname', $this->progname])
            ->andFilterWhere(['like', 'awardedby', $this->awardedby]);

        return $dataProvider;
    }
}
