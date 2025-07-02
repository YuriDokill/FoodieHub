<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class TaskSearch extends Task
{
    public function rules()
    {
        return [
            [['id', 'event_id', 'assigned_to'], 'integer'],
            [['title', 'description', 'deadline', 'status'], 'safe'],
        ];
    }

    public function search($params)
    {
        $query = Task::find()->with(['assignedUser', 'event']);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => 10,
            ],
            'sort' => [
                'defaultOrder' => [
                    'deadline' => SORT_ASC,
                ]
            ],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
            'event_id' => $this->event_id,
            'assigned_to' => $this->assigned_to,
            'deadline' => $this->deadline,
        ]);

        $query->andFilterWhere(['like', 'title', $this->title])
            ->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'status', $this->status]);

        return $dataProvider;
    }
}