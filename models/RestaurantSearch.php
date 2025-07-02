<?php
namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

class RestaurantSearch extends Restaurant
{
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['name', 'address', 'cuisine_type'], 'safe'],
            [['rating'], 'number'],
        ];
    }

    public function search($params)
    {
        $query = Restaurant::find();

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
            'rating' => $this->rating,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'cuisine_type', $this->cuisine_type]);

        return $dataProvider;
    }
}