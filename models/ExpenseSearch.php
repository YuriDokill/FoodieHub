<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class ExpenseSearch extends Expense
{
    public function rules()
    {
        return [
            [['id', 'event_id'], 'integer'],
            [['description', 'category'], 'safe'],
            [['amount'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = Expense::find()->with(['event']);

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
            'amount' => $this->amount,
        ]);

        $query->andFilterWhere(['like', 'description', $this->description])
            ->andFilterWhere(['like', 'category', $this->category]);

        return $dataProvider;
    }
}