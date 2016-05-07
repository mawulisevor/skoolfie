<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Admdt;

/**
 * AdmdtSearch represents the model behind the search form about `backend\models\Admdt`.
 */
class AdmdtSearch extends Admdt
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['INDEX_NO', 'NAME', 'ENTRANCE_CERT', 'AWARDING_INSTITUTION', 'CERTIFICATE_NO', 'QUALIFICATION_INDEX_NO', 'CLASS', 'ENGLISH_LANGUAGE', 'MATHEMATICS', 'INTEGRATED_SCIENCE', 'SOCIAL_STUDIES', 'PHYSICS', 'CHEMISTRY', 'BIOLOGY', 'ELECTIVE_MATHEMATICS', 'GENERAL_AGRICULTURE', 'CROP_HUSBANDRY', 'ANIMAL_HUSBANDRY'], 'safe'],
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
        $query = Admdt::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere(['like', 'INDEX_NO', $this->INDEX_NO])
            ->andFilterWhere(['like', 'NAME', $this->NAME])
            ->andFilterWhere(['like', 'ENTRANCE_CERT', $this->ENTRANCE_CERT])
            ->andFilterWhere(['like', 'AWARDING_INSTITUTION', $this->AWARDING_INSTITUTION])
            ->andFilterWhere(['like', 'CERTIFICATE_NO', $this->CERTIFICATE_NO])
            ->andFilterWhere(['like', 'QUALIFICATION_INDEX_NO', $this->QUALIFICATION_INDEX_NO])
            ->andFilterWhere(['like', 'CLASS', $this->CLASS])
            ->andFilterWhere(['like', 'ENGLISH_LANGUAGE', $this->ENGLISH_LANGUAGE])
            ->andFilterWhere(['like', 'MATHEMATICS', $this->MATHEMATICS])
            ->andFilterWhere(['like', 'INTEGRATED_SCIENCE', $this->INTEGRATED_SCIENCE])
            ->andFilterWhere(['like', 'SOCIAL_STUDIES', $this->SOCIAL_STUDIES])
            ->andFilterWhere(['like', 'PHYSICS', $this->PHYSICS])
            ->andFilterWhere(['like', 'CHEMISTRY', $this->CHEMISTRY])
            ->andFilterWhere(['like', 'BIOLOGY', $this->BIOLOGY])
            ->andFilterWhere(['like', 'ELECTIVE_MATHEMATICS', $this->ELECTIVE_MATHEMATICS])
            ->andFilterWhere(['like', 'GENERAL_AGRICULTURE', $this->GENERAL_AGRICULTURE])
            ->andFilterWhere(['like', 'CROP_HUSBANDRY', $this->CROP_HUSBANDRY])
            ->andFilterWhere(['like', 'ANIMAL_HUSBANDRY', $this->ANIMAL_HUSBANDRY]);

        return $dataProvider;
    }
}
