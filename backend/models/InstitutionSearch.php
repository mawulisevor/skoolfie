<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Institution;

/**
 * InstitutionSearch represents the model behind the search form about `backend\models\Institution`.
 */
class InstitutionSearch extends Institution
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['inst_shortname', 'inst_name', 'inst_location', 'inst_post_address', 'inst_email', 'inst_est_date', 'logo'], 'safe'],
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
        $query = Institution::find();

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
            'inst_est_date' => $this->inst_est_date,
        ]);

        $query->andFilterWhere(['like', 'inst_shortname', $this->inst_shortname])
            ->andFilterWhere(['like', 'inst_name', $this->inst_name])
            ->andFilterWhere(['like', 'inst_location', $this->inst_location])
            ->andFilterWhere(['like', 'inst_post_address', $this->inst_post_address])
            ->andFilterWhere(['like', 'inst_email', $this->inst_email])
            ->andFilterWhere(['like', 'logo', $this->logo]);

        return $dataProvider;
    }
}
