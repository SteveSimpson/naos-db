<?php

namespace app\models\db;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\db\Software;

/**
 * SoftwareSearch represents the model behind the search form of `app\models\db\Software`.
 */
class SoftwareSearch extends Software
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'licenses_total', 'licenses_used', 'dod_approval', 'critical'], 'integer'],
            [['name', 'type', 'version', 'manufacturer', 'license_or_contract', 'stig', 'hosts_os_notes', 'support_links', 'other_notes'], 'safe'],
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
        $query = Software::find();

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
            'licenses_total' => $this->licenses_total,
            'licenses_used' => $this->licenses_used,
            'dod_approval' => $this->dod_approval,
            'critical' => $this->critical,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'type', $this->type])
            ->andFilterWhere(['like', 'version', $this->version])
            ->andFilterWhere(['like', 'manufacturer', $this->manufacturer])
            ->andFilterWhere(['like', 'license_or_contract', $this->license_or_contract])
            ->andFilterWhere(['like', 'stig', $this->stig])
            ->andFilterWhere(['like', 'hosts_os_notes', $this->hosts_os_notes])
            ->andFilterWhere(['like', 'support_links', $this->support_links])
            ->andFilterWhere(['like', 'other_notes', $this->other_notes]);

        return $dataProvider;
    }
}
