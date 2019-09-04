<?php

namespace app\models\db;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\db\FwConfig;

/**
 * FwConfigSearch represents the model behind the search form of `app\models\db\FwConfig`.
 */
class FwConfigSearch extends FwConfig
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['fw_name', 'fw_type', 'notes', 'fw_config'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = FwConfig::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'fw_name', $this->fw_name])
            ->andFilterWhere(['like', 'fw_type', $this->fw_type])
            ->andFilterWhere(['like', 'fw_config', $this->fw_config])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
