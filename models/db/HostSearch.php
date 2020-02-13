<?php

namespace app\models\db;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\db\Host;

/**
 * HostSearch represents the model behind the search form of `app\models\db\Host`.
 */
class HostSearch extends Host
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'enabled', 'ipv4int', 'os_id', 'virtual', 'dod_approval', 'critical', 'hw_show'], 'integer'],
            [['hostname', 'fqdn', 'network_name', 'location_name', 'service', 'ipv4', 'ipv6', 'mask4', 'mask6', 'monitor_ip', 'notes', 'make', 'model', 'serial'], 'safe'],
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
        $query = Host::find();

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
            'enabled' => $this->enabled,
            'os_id' => $this->os_id,
            'virtual' => $this->virtual,
            'dod_approval' => $this->dod_approval,
            'critical' => $this->critical,
            'hw_show' => $this->hw_show,
        ]);

        $query->andFilterWhere(['like', 'hostname', $this->hostname])
            ->andFilterWhere(['like', 'fqdn', $this->fqdn])
            ->andFilterWhere(['like', 'network_name', $this->network_name])
            ->andFilterWhere(['like', 'location_name', $this->location_name])
            ->andFilterWhere(['like', 'service', $this->service])
            ->andFilterWhere(['like', 'ipv4', $this->ipv4])
            ->andFilterWhere(['like', 'ipv6', $this->ipv6])
            ->andFilterWhere(['like', 'mask4', $this->mask4])
            ->andFilterWhere(['like', 'mask6', $this->mask6])
            ->andFilterWhere(['like', 'make', $this->make])
            ->andFilterWhere(['like', 'model', $this->model])
            ->andFilterWhere(['like', 'mask6', $this->mask6])
            ->andFilterWhere(['like', 'serial', $this->serial])
            ->andFilterWhere(['like', 'notes', $this->notes]);

        return $dataProvider;
    }
}
