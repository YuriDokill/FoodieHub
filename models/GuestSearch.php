<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class GuestSearch extends Guest
{
    public function rules()
    {
        return [
            [['id', 'event_id', 'is_waiting'], 'integer'],
            [['name', 'contact_info', 'status'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Guest::find()->with(['event']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'event_id' => $this->event_id,
            'is_waiting' => $this->is_waiting,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'contact_info', $this->contact_info])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}