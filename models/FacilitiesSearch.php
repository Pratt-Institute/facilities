<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Facilities;

/**
 * FacilitiesSearch represents the model behind the search form of `app\models\Facilities`.
 */
class FacilitiesSearch extends Facilities
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['bldg_code', 'owned_leased', 'bldg_name', 'bldg_abbre', 'floor', 'room_no', 'new_room_no', 'line', 'status', 'station_count', 'sf', 'sf_fte', 'space_type', 'room_name', 'donor_space', 'av', 'ceiling_hgt', 'department', 'space', 'time', 'proration', 'calcuated_sf', 'function_code', 'major_category', 'functional_category', 'functional_title', 'on_off_campus', 'latitude', 'longitude', 'accessible'], 'safe'],
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
        $query = Facilities::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
				'pageSize' => 600,
			],
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

        $query->andFilterWhere(['like', 'bldg_code', $this->bldg_code])
            ->andFilterWhere(['like', 'owned_leased', $this->owned_leased])
            ->andFilterWhere(['like', 'bldg_name', $this->bldg_name])
            ->andFilterWhere(['like', 'bldg_abbre', $this->bldg_abbre])
            ->andFilterWhere(['like', 'floor', $this->floor])
            ->andFilterWhere(['like', 'room_no', $this->room_no])
            ->andFilterWhere(['like', 'new_room_no', $this->new_room_no])
            ->andFilterWhere(['like', 'line', $this->line])
            ->andFilterWhere(['like', 'status', $this->status])
            ->andFilterWhere(['like', 'station_count', $this->station_count])
            ->andFilterWhere(['like', 'sf', $this->sf])
            ->andFilterWhere(['like', 'sf_fte', $this->sf_fte])
            ->andFilterWhere(['like', 'space_type', $this->space_type])
            ->andFilterWhere(['like', 'room_name', $this->room_name])
            ->andFilterWhere(['like', 'donor_space', $this->donor_space])
            ->andFilterWhere(['like', 'av', $this->av])
            ->andFilterWhere(['like', 'ceiling_hgt', $this->ceiling_hgt])
            ->andFilterWhere(['like', 'department', $this->department])
            ->andFilterWhere(['like', 'space', $this->space])
            ->andFilterWhere(['like', 'time', $this->time])
            ->andFilterWhere(['like', 'proration', $this->proration])
            ->andFilterWhere(['like', 'calcuated_sf', $this->calcuated_sf])
            ->andFilterWhere(['like', 'function_code', $this->function_code])
            ->andFilterWhere(['like', 'major_category', $this->major_category])
            ->andFilterWhere(['like', 'functional_category', $this->functional_category])
            ->andFilterWhere(['like', 'functional_title', $this->functional_title])
            ->andFilterWhere(['like', 'on_off_campus', $this->on_off_campus])
            ->andFilterWhere(['like', 'accessible', $this->accessible]);

        return $dataProvider;
    }
}
