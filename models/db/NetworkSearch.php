<?php

namespace app\models\db;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\db\Network;

/**
 * NetworkSearch represents the model behind the search form of `app\models\db\Network`.
 */
class NetworkSearch extends Network
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['network_name', 'location_name', 'prefix4', 'prefix6', 'mask4', 'mask6', 'dnsdomain', 'notes'], 'safe'],
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
        $query = Network::find();

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

        $query->andFilterWhere(['like', 'network_name', $this->network_name])
            ->andFilterWhere(['like', 'location_name', $this->location_name])
            ->andFilterWhere(['like', 'prefix4', $this->prefix4])
            ->andFilterWhere(['like', 'prefix6', $this->prefix6])
            ->andFilterWhere(['like', 'mask4', $this->mask4])
            ->andFilterWhere(['like', 'mask6', $this->mask6])
            ->andFilterWhere(['like', 'dnsdomain', $this->dnsdomain])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
